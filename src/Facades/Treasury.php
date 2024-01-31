<?php

namespace Drradao\LaravelTreasury\Facades;

use Drradao\LaravelTreasury\TreasureKeeper;
use Drradao\LaravelTreasury\ValueObjects\CurrencySettings;
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
        return \Drradao\LaravelTreasury\Services\Treasury::class;
    }
}
