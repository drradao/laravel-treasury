<?php

namespace DRRAdao\LaravelTreasury\Exceptions;

class InvalidCurrency extends TreasuryException
{
    public function __construct(string $currency)
    {
        parent::__construct("Invalid currency: {$currency}.");
    }
}
