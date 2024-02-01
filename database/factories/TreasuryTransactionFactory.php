<?php

namespace DRRAdao\LaravelTreasury\Database\Factories;

use DRRAdao\LaravelTreasury\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \DRRAdao\LaravelTreasury\Models\TreasuryTransaction
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class TreasuryTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<model-property<TModel>, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }

    /**
     * State: Debit amount
     */
    public function debit(int $amount): static
    {
        return $this->state(function (array $attributes) use ($amount) {
            return [
                'amount' => $amount,
                'type' => TransactionType::Debit->value,
            ];
        });
    }

    /**
     * State: Credit amount
     */
    public function credit(int $amount): static
    {
        return $this->state(function (array $attributes) use ($amount) {
            return [
                'amount' => $amount,
                'type' => TransactionType::Credit->value,
            ];
        });
    }

    /**
     * State: Description
     */
    public function description(string $description): static
    {
        return $this->state(function (array $attributes) use ($description) {
            return [
                'description' => $description,
            ];
        });
    }
}
