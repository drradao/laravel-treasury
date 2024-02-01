<?php

namespace Drradao\LaravelTreasury;

use Carbon\CarbonInterface;
use Drradao\LaravelTreasury\Enums\TransactionType;
use Drradao\LaravelTreasury\Facades\Treasury;
use Drradao\LaravelTreasury\Models\TreasuryTransaction;
use Drradao\LaravelTreasury\Models\TreasuryVault;
use Drradao\LaravelTreasury\ValueObjects\CurrencySettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CurrencyVault
{
    public readonly CurrencySettings $currencySettings;

    protected TreasuryVault $vault;

    /**
     * CurrencyVault constructor.
     *
     * @throws Exceptions\InvalidCurrency
     */
    public function __construct(
        public readonly Model $owner,
        protected string $currencyName,
    ) {
        $this->currencySettings = Treasury::currency($currencyName);

        $this->vault = TreasuryVault::firstOrCreate([
            'owner_id' => $owner->getKey(),
            'owner_type' => $owner::class,
            'currency' => $currencyName,
        ]);
    }

    /**
     * Get balance of vault
     */
    public function balance(): int
    {
        return $this->vault->balance;
    }

    /**
     * Add amount to vault
     *
     * @throws Exceptions\NegativeAmoutPassed
     * @throws Exceptions\ExceedsMaximumBalance
     * @throws Exceptions\FailedToExecuteTransaction
     */
    public function credit(int $amount): static
    {
        if ($amount < 0) {
            throw new Exceptions\NegativeAmoutPassed($amount);
        }

        if ($this->vault->balance + $amount > $this->currencySettings->maxBalance) {
            throw new Exceptions\ExceedsMaximumBalance(
                balance: $this->vault->balance,
                amount: $amount,
                maximumBalance: $this->currencySettings->maxBalance,
            );
        }

        DB::beginTransaction();
        try {
            $this->vault->transactions()->create([
                'type' => TransactionType::Credit,
                'amount' => $amount,
            ]);

            $this->vault->increment('balance', $amount);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw new Exceptions\FailedToExecuteTransaction(
                type: TransactionType::Credit,
                previous: $e,
            );
        }

        return $this;
    }

    /**
     * Remove amount from vault
     *
     * @throws Exceptions\NegativeAmoutPassed
     * @throws Exceptions\InsufficientFunds
     * @throws Exceptions\FailedToExecuteTransaction
     */
    public function debit(int $amount): static
    {
        if ($amount < 0) {
            throw new Exceptions\NegativeAmoutPassed($amount);
        }

        if ($this->vault->balance - $amount < 0) {
            throw new Exceptions\InsufficientFunds(
                balance: $this->vault->balance,
                amount: $amount,
            );
        }

        DB::beginTransaction();
        try {
            $this->vault->transactions()->create([
                'type' => TransactionType::Debit,
                'amount' => $amount,
            ]);

            $this->vault->decrement('balance', $amount);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw new Exceptions\FailedToExecuteTransaction(
                type: TransactionType::Debit,
                previous: $e,
            );
        }

        return $this;
    }

    /**
     * Sync balance of vault
     *
     * This method will calculate the balance of the vault based on the transactions, and update the vault balance.
     *
     * @throws Exceptions\FailedToSyncBalance
     */
    public function sync(): static
    {
        $balance = 0;

        $this->vault->transactions()->chunk(255, function ($transactions) use (&$balance) {
            foreach ($transactions as $transaction) {
                if ($transaction->type == TransactionType::Credit) {
                    $balance += $transaction->amount;

                    continue;
                }

                $balance -= $transaction->amount;
            }
        });

        if ($balance < 0) {
            throw new Exceptions\FailedToSyncBalance(reason: 'Balance cannot be negative.');
        }

        try {
            $this->vault->update([
                'balance' => $balance,
            ]);
        } catch (\Throwable $e) {
            throw new Exceptions\FailedToSyncBalance(previous: $e);
        }

        return $this;
    }

    /**
     * Get transaction query builder
     *
     * @return Builder<TreasuryTransaction>
     */
    public function transactions(
        ?TransactionType $type = null,
        ?CarbonInterface $from = null,
        ?CarbonInterface $to = null,
    ): Builder {
        $query = $this->vault->transactions()->getQuery();

        if ($type instanceof TransactionType) {
            $query->type($type);
        }

        if ($from instanceof CarbonInterface) {
            $query->where('created_at', '>=', $from);
        }

        if ($to instanceof CarbonInterface) {
            $query->where('created_at', '<=', $to);
        }

        return $query;
    }
}
