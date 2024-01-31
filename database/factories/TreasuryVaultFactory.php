<?php

namespace Drradao\LaravelTreasury\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \Drradao\LaravelTreasury\Models\TreasuryVault
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class TreasuryVaultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<model-property<TModel>, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    /**
     * State: currency
     */
    public function currency(string $currency): static
    {
        return $this->state(function (array $attributes) use ($currency) {
            return [
                'currency' => $currency,
            ];
        });
    }

    /**
     * State: balance
     */
    public function balance(int $balance): static
    {
        return $this->state(function (array $attributes) use ($balance) {
            return [
                'balance' => $balance,
            ];
        });
    }
}
