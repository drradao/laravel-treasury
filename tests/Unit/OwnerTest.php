<?php

test('owner has vaults relationship', function () {
    $user = \Drradao\LaravelTreasury\Tests\Models\User::factory()->create();

    $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->treasuryVaults);
});

test('owner can access a vault', function () {
    $user = \Drradao\LaravelTreasury\Tests\Models\User::factory()->create();

    expect($user->vault('credits'))->toBeInstanceOf(\Drradao\LaravelTreasury\CurrencyVault::class);

    \Pest\Laravel\assertDatabaseHas('treasury_vaults', [
        'owner_id' => $user->id,
        'owner_type' => $user::class,
        'currency' => 'credits',
    ]);
});

test('owner cannot access invalid vault', function () {
    $user = \Drradao\LaravelTreasury\Tests\Models\User::factory()->create();

    $user->vault('unicorns');
})->throws(\Drradao\LaravelTreasury\Exceptions\InvalidCurrency::class);
