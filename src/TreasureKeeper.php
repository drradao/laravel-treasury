<?php

namespace Drradao\LaravelTreasury;

use Drradao\LaravelTreasury\Contracts\VaultOwner;
use Drradao\LaravelTreasury\Exceptions\InvalidCurrency;
use Drradao\LaravelTreasury\Exceptions\InvalidVaultOwner;
use Illuminate\Database\Eloquent\Model;

class TreasureKeeper
{
    /**
     * TreasureKeeper constructor.
     *
     * @throws InvalidVaultOwner
     */
    public function __construct(
        public readonly Model $owner,
    ) {
        if (! $owner instanceof VaultOwner) {
            throw new Exceptions\InvalidVaultOwner($owner);
        }
    }

    /**
     * Get currency vault for owner
     *
     * @throws InvalidCurrency
     */
    public function currency(string $name): CurrencyVault
    {
        return new CurrencyVault($this->owner, $name);
    }
}
