<?php

namespace NathanDunn\Countries\Tests\Unit\Countries;

use NathanDunn\Countries\Continents\Continent;
use NathanDunn\Countries\Countries\Country;
use NathanDunn\Countries\Currencies\Currency;
use NathanDunn\Countries\Tests\Unit\ModelTest;

class CountryTest extends ModelTest
{
    protected string $model = Country::class;

    /** @test */
    public function country_belongs_to_continent()
    {
        $this->belongsToTest(Continent::class, 'continent', 'continent_id');
    }

    /** @test */
    public function country_belongs_to_many_currencies()
    {
        $this->belongsToManyTest(Currency::class, 'currencies');
    }
}