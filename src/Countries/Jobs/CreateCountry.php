<?php

namespace NathanDunn\Countries\Countries\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use NathanDunn\Countries\Countries\CountryRepository;
use NathanDunn\Countries\Currencies\CurrencyRepository;

class CreateCountry extends CountryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CountryRepository $countryRepository, CurrencyRepository $currencyRepository)
    {
        $country = $countryRepository->newInstance();
        $country = $this->fillCountry($country, $this->data);
        $country->save();

        $currencies = Arr::get($this->data, 'currencies', []);
        $currencyIds = $this->formatCurrencyIds($currencyRepository, $currencies);
        $country->currencies()->sync($currencyIds);
    }
}
