<?php

namespace NathanDunn\Countries\Tests\Unit\Currencies\Jobs;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Arr;
use NathanDunn\Countries\Continents\Continent;
use NathanDunn\Countries\Continents\ContinentRepository;
use NathanDunn\Countries\Countries\Country;
use NathanDunn\Countries\Countries\Jobs\UpdateCountry;
use NathanDunn\Countries\Currencies\Currency;
use NathanDunn\Countries\Currencies\CurrencyRepository;
use NathanDunn\Countries\Currencies\Jobs\UpdateCurrency;
use NathanDunn\Countries\Tests\TestCase;

class UpdateCountryTest extends TestCase
{
    /** @test */
    public function can_update_country()
    {
        $country = Country::factory()->create();
        $data = $this->getCountries();
        $countryData = Arr::first($data);
        /** @var CurrencyRepository $currencyRepository */
        $currencyRepository = app(CurrencyRepository::class);
        /** @var ContinentRepository $currencyRepository */
        $continentRepository = app(ContinentRepository::class);

        Continent::factory()->create(['name' => 'Asia']);

        (new UpdateCountry($country, $countryData))->handle($currencyRepository, $continentRepository);

        $this->assertDatabaseHas('countries', ['alpha_3_code' => Arr::get($countryData, 'cca3')]);
    }
}