<?php

use DRRAdao\LaravelTreasury\CurrencyVault;
use DRRAdao\LaravelTreasury\Models\TreasuryTransaction;
use DRRAdao\LaravelTreasury\Models\TreasuryVault;
use DRRAdao\LaravelTreasury\Tests\Models\User;

it('can add to balance', function () {
    $user = User::factory()->create();
    $currencyVault = new CurrencyVault(
        owner: $user,
        currencyName: 'credits',
    );

    $currencyVault->credit(100);

    expect($currencyVault->balance())->toBe(100);
});

it('can subtract from balance', function () {
    $user = User::factory()->create();
    $currencyVault = new CurrencyVault(
        owner: $user,
        currencyName: 'credits',
    );

    $currencyVault->credit(100);
    $currencyVault->debit(50);

    expect($currencyVault->balance())->toBe(50);
});

it('doesnot allow negative balance', function () {
    $user = User::factory()->create();
    $currencyVault = new CurrencyVault(
        owner: $user,
        currencyName: 'credits',
    );

    $currencyVault->debit(100);
})->throws(\DRRAdao\LaravelTreasury\Exceptions\InsufficientFunds::class);

it('doesn\'t allow negative amounts', function () {
    $user = User::factory()->create();
    $currencyVault = new CurrencyVault(
        owner: $user,
        currencyName: 'credits',
    );

    expect(fn () => $currencyVault->credit(-100))
        ->toThrow(\DRRAdao\LaravelTreasury\Exceptions\NegativeAmoutPassed::class);
    expect(fn () => $currencyVault->debit(-100))
        ->toThrow(\DRRAdao\LaravelTreasury\Exceptions\NegativeAmoutPassed::class);
});

it('validates the max balance', function () {
    config()->set('treasury.currencies.credits.max_balance', 100);

    $user = User::factory()->create();
    $currencyVault = new CurrencyVault(
        owner: $user,
        currencyName: 'credits',
    );

    $currencyVault->credit(101);
})->throws(\DRRAdao\LaravelTreasury\Exceptions\ExceedsMaximumBalance::class);

it('can sync balance', function () {
    $user = User::factory()->create();
    TreasuryVault::factory()
        ->for($user, 'owner')
        ->currency('credits')
        ->has(
            TreasuryTransaction::factory()
                ->count(2)
                ->sequence(
                    [
                        'amount' => 125,
                        'type' => \DRRAdao\LaravelTreasury\Enums\TransactionType::Credit,
                    ],
                    [
                        'amount' => 75,
                        'type' => \DRRAdao\LaravelTreasury\Enums\TransactionType::Debit,
                    ],
                ),
            'transactions'
        )
        ->create();

    $vault = $user->treasuryVaults()->with('transactions')->first();

    expect($vault)
        ->balance
        ->toBe(0)
        ->transactions
        ->toHaveCount(2);

    $vault = $user->vault('credits')->syncBalance();

    expect($vault)
        ->balance()
        ->toBe(50);
});

it('fails to sync negative balance', function () {
    $user = User::factory()->create();
    TreasuryVault::factory()
        ->for($user, 'owner')
        ->currency('credits')
        ->has(
            TreasuryTransaction::factory()
                ->count(2)
                ->sequence(
                    [
                        'amount' => 100,
                        'type' => \DRRAdao\LaravelTreasury\Enums\TransactionType::Credit,
                    ],
                    [
                        'amount' => 200,
                        'type' => \DRRAdao\LaravelTreasury\Enums\TransactionType::Debit,
                    ],
                ),
            'transactions'
        )
        ->create();

    $user->vault('credits')->syncBalance();
})->throws(\DRRAdao\LaravelTreasury\Exceptions\FailedToSyncBalance::class);
