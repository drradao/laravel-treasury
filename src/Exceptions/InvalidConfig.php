<?php

namespace Drradao\LaravelTreasury\Exceptions;

class InvalidConfig extends TreasuryException
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? 'Invalid config.');
    }
}
