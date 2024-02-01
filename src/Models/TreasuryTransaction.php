<?php

namespace Drradao\LaravelTreasury\Models;

use Drradao\LaravelTreasury\Enums\TransactionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'vault_id',
        'amount',
        'type',
        'description',
    ];

    protected $casts = [
        'amount' => 'integer',
        'type' => TransactionType::class,
    ];

    /**
     * Vault of the transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TreasuryVault,TreasuryTransaction>
     */
    public function vault(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TreasuryVault::class);
    }

    /**
     * Scope a query to only include debits.
     *
     * @param  Builder<TreasuryTransaction>  $query
     * @return Builder<TreasuryTransaction>
     */
    public function scopeDebit(Builder $query): Builder
    {
        return $query->where('type', TransactionType::Debit->value);
    }

    /**
     * Scope a query to only include credits.
     *
     * @param  Builder<TreasuryTransaction>  $query
     * @return Builder<TreasuryTransaction>
     */
    public function scopeCredit(Builder $query): Builder
    {
        return $query->where('type', TransactionType::Credit->value);
    }

    /**
     * Scope by type
     *
     * @param  Builder<TreasuryTransaction>  $query
     * @return Builder<TreasuryTransaction>
     */
    public function scopeType(Builder $query, TransactionType $type): Builder
    {
        return $query->where('type', $type->value);
    }
}
