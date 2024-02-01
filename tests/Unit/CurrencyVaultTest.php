<?php

use Drradao\LaravelTreasury\CurrencyVault;
use Drradao\LaravelTreasury\Tests\Models\User;

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
})->throws(\Drradao\LaravelTreasury\Exceptions\InsufficientFunds::class);

it('doesn\'t allow negative amounts', function () {
    $user = User::factory()->create();
    $currencyVault = new CurrencyVault(
        owner: $user,
        currencyName: 'credits',
    );

    expect(fn () => $currencyVault->credit(-100))
        ->toThrow(\Drradao\LaravelTreasury\Exceptions\NegativeAmoutPassed::class);
    expect(fn () => $currencyVault->debit(-100))
        ->toThrow(\Drradao\LaravelTreasury\Exceptions\NegativeAmoutPassed::class);
});

it('validates the max balance', function () {
    config()->set('treasury.currencies.credits.max_balance', 100);

    $user = User::factory()->create();
    $currencyVault = new CurrencyVault(
        owner: $user,
        currencyName: 'credits',
    );

    $currencyVault->credit(101);
})->throws(\Drradao\LaravelTreasury\Exceptions\ExceedsMaximumBalance::class);
