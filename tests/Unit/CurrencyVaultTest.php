<?php

use DRRAdao\LaravelTreasury\CurrencyVault;
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
