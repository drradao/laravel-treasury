<?php

namespace Drradao\LaravelTreasury;

use Drradao\LaravelTreasury\Exceptions\InvalidCurrency;
use Drradao\LaravelTreasury\Facades\Treasury;
use Drradao\LaravelTreasury\Models\TreasuryVault;
use Drradao\LaravelTreasury\ValueObjects\CurrencySettings;
use Illuminate\Database\Eloquent\Model;

class CurrencyVault
{
    public readonly CurrencySettings $currencySettings;

    protected TreasuryVault $vault;

    /**
     * CurrencyVault constructor.
     *
     * @throws InvalidCurrency
     */
    public function __construct(
        public readonly Model $owner,
        protected string $currencyName,
    ) {
        $this->currencySettings = Treasury::currency($currencyName);

        $this->vault = TreasuryVault::firstOrCreate([
            'owner_id' => $owner->getKey(),
            'owner_type' => $owner::class,
            'currency' => $currencyName,
        ]);
    }
}
