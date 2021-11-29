<?php

namespace NathanDunn\Countries\Tests\Unit\Countries\Jobs;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Arr;
use NathanDunn\Countries\Continents\Continent;
use NathanDunn\Countries\Countries\CountryRepository;
use NathanDunn\Countries\Countries\Jobs\SyncCountry;
use NathanDunn\Countries\Tests\TestCase;

class SyncCountryTest extends TestCase
{
    /** @test */
    public function can_sync_country()
    {
        $data = $this->getCountries();
        $countryData = Arr::first($data);
        /** @var CountryRepository $countryRepository */
        $countryRepository = app(CountryRepository::class);
        /** @var Dispatcher $dispatcher */
        $dispatcher = app(Dispatcher::class);

        Continent::factory()->create(['name' => 'Asia']);

        (new SyncCountry($countryData))
            ->handle($countryRepository, $dispatcher);

        $this->assertDatabaseHas('countries', ['alpha_3_code' => Arr::get($countryData, 'cca3')]);
    }
}