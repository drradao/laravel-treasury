<?php

namespace DRRAdao\LaravelTreasury;

use DRRAdao\LaravelTreasury\Services\Treasury;
use Illuminate\Support\ServiceProvider;

class TreasuryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'treasury');

        $this->app->singleton(Treasury::class, function () {
            return new Treasury();
        });
    }
}
