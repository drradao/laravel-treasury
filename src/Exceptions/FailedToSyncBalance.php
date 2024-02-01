<?php

namespace DRRAdao\LaravelTreasury\Exceptions;

class FailedToSyncBalance extends TreasuryException
{
    public function __construct(?string $reason = null, ?\Throwable $previous = null)
    {
        parent::__construct(
            message: implode(' ', ['Failed to sync balance.', $reason]),
            previous: $previous,
        );
    }
}
