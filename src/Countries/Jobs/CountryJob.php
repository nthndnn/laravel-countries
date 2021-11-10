<?php

namespace NathanDunn\Countries\Countries\Jobs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use NathanDunn\Countries\Countries\Country;
use NathanDunn\Countries\Currencies\Currency;
use NathanDunn\Countries\Currencies\CurrencyRepository;

abstract class CountryJob
{
    protected function fillCountry(Country $country, array $data): Country
    {
        $latLong = Arr::get($data, 'latlng', []);

        $country->name_official = Arr::get($data, 'name.official');
        $country->name_common = Arr::get($data, 'name.common');
        $country->region = Arr::get($data, 'region');
        $country->subregion = Arr::get($data, 'subregion');
        $country->alpha_2_code = Arr::get($data, 'cca2');
        $country->alpha_3_code = Arr::get($data, 'cca3');
        $country->latitude = Arr::first($latLong);
        $country->longitude = Arr::last($latLong);
        $country->independent = Arr::get($data, 'independent');
        $country->un_member = Arr::get($data, 'unMember');

        return $country;
    }

    protected function formatCurrencyIds(CurrencyRepository $currencyRepository, array $currencies): array
    {
        return Collection::wrap($currencies)
            ->map(function ($currency, $currencyCode) use ($currencyRepository) {
                return $currencyRepository->firstByCode($currencyCode);
            })
            ->filter()
            ->map(function (Currency $currency) {
                return $currency->id;
            })
            ->flatten()
            ->toArray();
    }
}
