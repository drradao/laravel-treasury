<?php

namespace Drradao\LaravelTreasury\Exceptions;

class ExceedsMaximumBalance extends TreasuryException
{
    public function __construct(
        public readonly int $balance,
        public readonly int $amount,
        public readonly int $maximumBalance,
    ) {
        parent::__construct(
            message: 'Maximum balance exceeded. Tried to add '.$amount.' to a vault with '.$balance.' balance.'
                .' Maximum balance is '.$maximumBalance.'.'
        );
    }
}
