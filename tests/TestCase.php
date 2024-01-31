<?php

namespace Drradao\LaravelTreasury\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            \Drradao\LaravelTreasury\TreasuryServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->enablesPackageDiscoveries = true;

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
