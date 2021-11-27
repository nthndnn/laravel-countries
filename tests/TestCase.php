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
}
