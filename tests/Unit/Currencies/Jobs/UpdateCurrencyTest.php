<?php

namespace NathanDunn\Countries\Tests\Unit\Currencies\Jobs;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Arr;
use NathanDunn\Countries\Currencies\Currency;
use NathanDunn\Countries\Currencies\CurrencyRepository;
use NathanDunn\Countries\Currencies\Jobs\UpdateCurrency;
use NathanDunn\Countries\Tests\TestCase;

class UpdateCurrencyTest extends TestCase
{
    /** @test */
    public function can_update_currency()
    {
        $currency = Currency::factory()->create();
        $data = $this->getCurrency();
        /** @var Dispatcher $dispatcher */
        $dispatcher = app(Dispatcher::class);
        /** @var CurrencyRepository $currencyRepository */
        $currencyRepository = app(CurrencyRepository::class);

        (new UpdateCurrency($currency, $data))
            ->handle($currencyRepository, $dispatcher);

        $this->assertDatabaseHas('currencies', ['code' => Arr::get($data, 'code')]);
    }
}