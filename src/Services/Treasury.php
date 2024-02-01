<?php

namespace DRRAdao\LaravelTreasury\Services;

use DRRAdao\LaravelTreasury\Exceptions\InvalidConfig;
use DRRAdao\LaravelTreasury\Exceptions\InvalidCurrency;
use DRRAdao\LaravelTreasury\Exceptions\InvalidVaultOwner;
use DRRAdao\LaravelTreasury\TreasureKeeper;
use DRRAdao\LaravelTreasury\ValueObjects\CurrencySettings;
use Illuminate\Database\Eloquent\Model;

class Treasury
{
    /**
     * All currencies settings
     *
     * @var array<string,CurrencySettings>
     */
    protected array $currencies = [];

    /**
     * Treasury constructor.
     *
     * @throws InvalidConfig
     */
    public function __construct()
    {
        $currencies = config('treasury.currencies', []);

        if (! is_array($currencies)) {
            throw new InvalidConfig('Invalid currencies config');
        }

        foreach ($currencies as $currency => $settings) {
            if (! is_array($settings) || ! isset($settings['max_balance'])) {
                throw new InvalidConfig('Invalid currencies config');
            }

            $this->currencies[$currency] = new CurrencySettings(
                name: $currency,
                maxBalance: $settings['max_balance'],
            );
        }
    }

    /**
     * Get treasure keeper for owner
     *
     * @throws InvalidVaultOwner
     */
    public function of(Model $owner): TreasureKeeper
    {
        return new TreasureKeeper($owner);
    }

    /**
     * Get currency settings
     *
     * @throws InvalidCurrency
     */
    public function currency(string $currency): CurrencySettings
    {
        if (! isset($this->currencies[$currency])) {
            throw new InvalidCurrency($currency);
        }

        return $this->currencies[$currency];
    }
}
