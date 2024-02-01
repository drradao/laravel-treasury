<?php

namespace DRRAdao\LaravelTreasury\Exceptions;

use DRRAdao\LaravelTreasury\Enums\TransactionType;

class FailedToExecuteTransaction extends TreasuryException
{
    public function __construct(
        public readonly TransactionType $type,
        \Throwable $previous,
    ) {
        parent::__construct(
            message: 'Failed to execute '.$type->value.' transaction.',
            previous: $previous,
        );
    }
}
