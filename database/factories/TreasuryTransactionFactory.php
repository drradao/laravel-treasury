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
    protected $model = \DRRAdao\LaravelTreasury\Models\TreasuryTransaction::class;

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
     * State: Random amount and type
     */
    public function random(int $min = 1, int $max = 100): static
    {
        return $this->state(function (array $attributes) use ($min, $max) {
            return [
                'amount' => $this->faker->numberBetween($min, $max),
                'type' => rand() ? TransactionType::Credit->value : TransactionType::Debit->value,
            ];
        });
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
