<?php

namespace NathanDunn\Countries\Tests\Unit\Currencies\Jobs;

use Illuminate\Support\Arr;
use NathanDunn\Countries\Currencies\CurrencyRepository;
use NathanDunn\Countries\Currencies\Jobs\CreateCurrency;
use NathanDunn\Countries\Tests\TestCase;

class CreateCurrencyTest extends TestCase
{
    /** @test */
    public function can_create_currency()
    {
        $currency = $this->getCurrency();
        /** @var CurrencyRepository $currencyRepository */
        $currencyRepository = app(CurrencyRepository::class);

        (new CreateCurrency($currency))
            ->handle($currencyRepository);

        $this->assertDatabaseHas('currencies', ['code' => Arr::get($currency, 'code')]);
    }
}