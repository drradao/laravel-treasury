<?php

namespace DRRAdao\LaravelTreasury\Exceptions;

class InvalidVaultOwner extends TreasuryException
{
    public function __construct(object $owner)
    {
        parent::__construct('Invalid vault owner: '.$owner::class);
    }
}
