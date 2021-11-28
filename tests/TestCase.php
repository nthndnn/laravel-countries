<?php

namespace NathanDunn\Countries\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use NathanDunn\Countries\CountriesServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            CountriesServiceProvider::class,
        ];
    }

    protected function getCountries(): array
    {
        $countries = file_get_contents(__DIR__ . '/countries.json');

        return json_decode($countries, true);
    }

    protected function getCurrency(): array
    {
        $countries = file_get_contents(__DIR__ . '/currency.json');

        return json_decode($countries, true);
    }
}
