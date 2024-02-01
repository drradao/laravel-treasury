<?php

namespace DRRAdao\LaravelTreasury\Facades;

use DRRAdao\LaravelTreasury\TreasureKeeper;
use DRRAdao\LaravelTreasury\ValueObjects\CurrencySettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static TreasureKeeper of(Model $owner)
 * @method static CurrencySettings currency(string $name)
 */
class Treasury extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \DRRAdao\LaravelTreasury\Services\Treasury::class;
    }
}
