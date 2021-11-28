<?php

namespace NathanDunn\Countries\Tests\Unit\Currencies;

use NathanDunn\Countries\Countries\Country;
use NathanDunn\Countries\Currencies\Currency;
use NathanDunn\Countries\Tests\Unit\ModelTest;

class CurrencyTest extends ModelTest
{
    protected string $model = Currency::class;

    /** @test */
    public function currency_belongs_to_many_countries()
    {
        $this->belongsToManyTest(Country::class, 'countries');
    }
}