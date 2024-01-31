<?php

namespace Drradao\LaravelTreasury\ValueObjects;

class CurrencySettings
{
    public function __construct(
        public readonly string $name,
        public readonly string $limit,
    ) {
        //
    }
}
