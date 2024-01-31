<?php

namespace Drradao\LaravelTreasury\Traits;

use Drradao\LaravelTreasury\Exceptions\InvalidCurrency;
use Drradao\LaravelTreasury\Facades\Treasury;

trait HasVaults
{
    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param  string  $related
     * @param  string  $name
     * @param  string|null  $type
     * @param  string|null  $id
     * @param  string|null  $localKey
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    public function treasuryVaults(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\Drradao\LaravelTreasury\Models\TreasuryVault::class, 'owner');
    }

    /**
     * Get currency vault for owner
     *
     * @throws InvalidVaultOwner
     * @throws InvalidCurrency
     */
    public function vault(string $name): \Drradao\LaravelTreasury\CurrencyVault
    {
        return Treasury::of($this)->currency($name);
    }
}
