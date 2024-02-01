<?php

namespace DRRAdao\LaravelTreasury\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

trait HasPackageFactory
{
    use HasFactory;

    /**
     * New factory instance.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        /**
         * Build the factory class name.
         *
         * @var class-string<\Illuminate\Database\Eloquent\Factories\Factory<static>> $factoryClass
         */
        $factoryClass = Str::of(static::class)
            ->after('Models\\')
            ->prepend('DRRAdao\\LaravelTreasury\\Database\\Factories\\')
            ->append('Factory')
            ->toString();

        return new $factoryClass;
    }
}
