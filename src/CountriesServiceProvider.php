<?php

namespace NathanDunn\Countries;

use NathanDunn\Countries\Console\Commands\SyncCountries;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CountriesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('countries')
            ->hasConfigFile()
            ->hasMigrations(
                'create_countries_table',
                'create_currencies_table',
                'create_country_currency_table'
            )
            ->hasCommands(SyncCountries::class);
    }
}
