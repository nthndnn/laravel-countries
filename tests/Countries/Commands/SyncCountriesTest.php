<?php

namespace NathanDunn\Countries\Tests\Countries\Commands;

use Illuminate\Support\Facades\Http;
use NathanDunn\Countries\Tests\TestCase;

class SyncCountriesTest extends TestCase
{
    /** @test */
    public function can_sync_country()
    {
        $countries = $this->getCountries();
        Http::fake([
            'restcountries.com/v3.1/all' => Http::response(
                $countries,
                200,
                ['Content-Type' => 'application/json']
            ),
        ]);

        $this->artisan('countries:sync')->assertExitCode(0);
    }
}