<?php

namespace NathanDunn\Countries;

use NathanDunn\Countries\Console\Commands\SyncCountries;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CountriesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
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
