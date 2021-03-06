<?php

namespace NathanDunn\Countries;

use Illuminate\Support\ServiceProvider;
use NathanDunn\Countries\Countries\Commands\SyncCountries;

class CountriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/countries.php' => config_path('countries.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/countries.php',
            'countries'
        );

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->commands(SyncCountries::class);
    }
}
