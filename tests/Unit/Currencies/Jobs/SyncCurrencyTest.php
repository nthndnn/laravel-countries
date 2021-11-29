<?php

namespace NathanDunn\Countries\Tests\Unit\Currencies\Jobs;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Arr;
use NathanDunn\Countries\Currencies\CurrencyRepository;
use NathanDunn\Countries\Currencies\Jobs\SyncCurrency;
use NathanDunn\Countries\Tests\TestCase;

class SyncCurrencyTest extends TestCase
{
    /** @test */
    public function can_create_currency()
    {
        $currency = $this->getCurrency();
        /** @var CurrencyRepository $currencyRepository */
        $currencyRepository = app(CurrencyRepository::class);
        /** @var Dispatcher $dispatcher */
        $dispatcher = app(Dispatcher::class);

        (new SyncCurrency($currency))
            ->handle($currencyRepository, $dispatcher);

        $this->assertDatabaseHas('currencies', ['code' => Arr::get($currency, 'code')]);
    }
}