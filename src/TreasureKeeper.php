<?php

namespace DRRAdao\LaravelTreasury;

use DRRAdao\LaravelTreasury\Contracts\VaultOwner;
use DRRAdao\LaravelTreasury\Exceptions\InvalidCurrency;
use DRRAdao\LaravelTreasury\Exceptions\InvalidVaultOwner;
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
