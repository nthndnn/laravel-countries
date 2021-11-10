<?php

namespace NathanDunn\Countries;

use Illuminate\Support\ServiceProvider;
use NathanDunn\Countries\Commands\SyncCountries;

class CountriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the package services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->commands(SyncCountries::class);
    }
}
