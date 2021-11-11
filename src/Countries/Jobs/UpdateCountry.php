<?php

namespace NathanDunn\Countries\Countries\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use NathanDunn\Countries\Continents\ContinentRepository;
use NathanDunn\Countries\Countries\Country;
use NathanDunn\Countries\Currencies\CurrencyRepository;

class UpdateCountry extends CountryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Country $country;

    protected array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Country $country, array $data)
    {
        $this->country = $country;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CurrencyRepository $currencyRepository, ContinentRepository $continentRepository)
    {
        $continents = Arr::get($this->data, 'continents');
        $continent = $continentRepository->firstByName(Arr::first($continents));

        $country = $this->country;
        $country = $this->fillCountry($country, $this->data);
        $country->continent()->associate($continent);
        $country->save();

        $currencies = Arr::get($this->data, 'currencies', []);
        $currencyIds = $this->formatCurrencyIds($currencyRepository, $currencies);
        $country->currencies()->sync($currencyIds);
    }
}
