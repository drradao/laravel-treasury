<?php

namespace DRRAdao\LaravelTreasury\ValueObjects;

class CurrencySettings
{
    public function __construct(
        public readonly string $name,
        public readonly int $maxBalance,
    ) {
        //
    }
}
