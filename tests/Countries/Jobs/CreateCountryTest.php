<?php

namespace NathanDunn\Countries\Tests\Countries\Jobs;

use Illuminate\Support\Arr;
use NathanDunn\Countries\Continents\Continent;
use NathanDunn\Countries\Continents\ContinentRepository;
use NathanDunn\Countries\Countries\CountryRepository;
use NathanDunn\Countries\Countries\Jobs\CreateCountry;
use NathanDunn\Countries\Currencies\CurrencyRepository;
use NathanDunn\Countries\Tests\TestCase;

class CreateCountryTest extends TestCase
{
    /** @test */
    public function can_create_country()
    {
        $data = $this->getCountries();
        $countryData = Arr::first($data);
        /** @var CountryRepository $countryRepository */
        $countryRepository = app(CountryRepository::class);
        /** @var CurrencyRepository $currencyRepository */
        $currencyRepository = app(CurrencyRepository::class);
        /** @var ContinentRepository $continentRepository */
        $continentRepository = app(ContinentRepository::class);

        Continent::factory()->create(['name' => 'Asia']);

        (new CreateCountry($countryData))
            ->handle($countryRepository, $currencyRepository, $continentRepository);

        $this->assertDatabaseHas('countries', ['alpha_3_code' => Arr::get($countryData, 'cca3')]);
    }
}