<?php

namespace Drradao\LaravelTreasury\Tests\Models;

use Drradao\LaravelTreasury\Traits\HasVaults;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends \Illuminate\Foundation\Auth\User implements \Drradao\LaravelTreasury\Contracts\VaultOwner
{
    use HasFactory;
    use HasVaults;

    protected static function newFactory()
    {
        return new \Drradao\LaravelTreasury\Tests\Factories\UserFactory();
    }
}
