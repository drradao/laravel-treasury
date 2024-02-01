<?php

namespace DRRAdao\LaravelTreasury\Tests\Models;

use DRRAdao\LaravelTreasury\Traits\HasVaults;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends \Illuminate\Foundation\Auth\User implements \DRRAdao\LaravelTreasury\Contracts\VaultOwner
{
    use HasFactory;
    use HasVaults;

    protected static function newFactory()
    {
        return new \DRRAdao\LaravelTreasury\Tests\Factories\UserFactory();
    }
}
