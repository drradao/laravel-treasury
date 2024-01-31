<?php

namespace Drradao\LaravelTreasury\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryVault extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'owner_id',
        'owner_type',
    ];

    /**
     * Owner of the vault
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model,TreasuryVault>
     */
    public function owner(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
