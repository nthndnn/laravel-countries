<?php

namespace NathanDunn\Countries\Tests\Unit\Continents;

use NathanDunn\Countries\Continents\Continent;
use NathanDunn\Countries\Countries\Country;
use NathanDunn\Countries\Tests\Unit\ModelTest;

class ContinentTest extends ModelTest
{
    protected string $model = Continent::class;

    /** @test */
    public function continent_has_many_countries()
    {
        $this->hasManyTest(Country::class, 'countries', 'continent_id', 'continent');
    }
}