<?php

namespace Drradao\LaravelTreasury\Exceptions;

class InsufficientFunds extends TreasuryException
{
    public function __construct(
        public readonly int $balance,
        public readonly int $amount,
    ) {
        parent::__construct(
            message: 'No funds to debit, tried to debit '.$amount.' but balance is '.$balance.'.',
        );
    }
}
