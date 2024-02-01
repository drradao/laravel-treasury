<?php

namespace DRRAdao\LaravelTreasury\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \DRRAdao\LaravelTreasury\Models\TreasuryVault
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class TreasuryVaultFactory extends Factory
{
    protected $model = \DRRAdao\LaravelTreasury\Models\TreasuryVault::class;

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
