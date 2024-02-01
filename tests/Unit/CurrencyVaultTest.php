<?php

use Drradao\LaravelTreasury\CurrencyVault;
use Drradao\LaravelTreasury\Tests\Models\User;

test('currency vault can credit', function () {
    $user = User::factory()->create();
    $currencyVault = new CurrencyVault(
        owner: $user,
        currencyName: 'credits',
    );

    $currencyVault->credit(100);

    expect($currencyVault->balance())->toBe(100);
});
