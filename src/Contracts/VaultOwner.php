<?php

namespace Drradao\LaravelTreasury\Contracts;

use Drradao\LaravelTreasury\Models\TreasuryVault;

interface VaultOwner
{
    /**
     * Relationship: Treasury vaults
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<TreasuryVault>
     */
    public function treasuryVaults(): \Illuminate\Database\Eloquent\Relations\MorphMany;
}
