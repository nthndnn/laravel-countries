<?php

namespace NathanDunn\Countries;

use NathanDunn\Countries\Commands\SyncCountries;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CountriesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-countries')
            ->hasConfigFile()
            ->hasMigrations(
                '2021_11_10_000000_create_countries_table',
                '2021_11_10_000001_create_currencies_table',
                '2021_11_10_000003_create_country_currency_table'
            )
            ->hasCommands(SyncCountries::class);
    }
}
