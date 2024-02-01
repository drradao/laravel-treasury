<?php

namespace DRRAdao\LaravelTreasury\Exceptions;

class NegativeAmoutPassed extends TreasuryException
{
    public function __construct(int $amount)
    {
        parent::__construct("Negative amount passed: {$amount}");
    }
}
