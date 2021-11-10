<?php

namespace NathanDunn\Countries\Currencies\Jobs;

use Illuminate\Support\Arr;
use NathanDunn\Countries\Currencies\Currency;

abstract class CurrencyJob
{
    protected function fillCurrency(Currency $currency, array $data): Currency
    {
        $currency->name = Arr::get($data, 'name');
        $currency->symbol = Arr::get($data, 'symbol');
        $currency->code = Arr::get($data, 'code');

        return $currency;
    }
}
