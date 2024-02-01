<?php

namespace DRRAdao\LaravelTreasury\Models;

use DRRAdao\LaravelTreasury\Traits\HasPackageFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TreasuryVault extends Model
{
    use HasPackageFactory;

    protected $fillable = [
        'currency',
        'owner_id',
        'owner_type',
        'balance',
    ];

    /**
     * Owner of the vault
     *
     * @return MorphTo<Model,TreasuryVault>
     */
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Transactions of the vault
     *
     * @return HasMany<TreasuryTransaction>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(TreasuryTransaction::class);
    }
}
