<?php

namespace NathanDunn\Countries\Jobs;

use NathanDunn\Countries\Country;
use App\Currencies\Currency;
use App\Currencies\CurrencyRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class UpdateCountry implements ShouldQueue
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
    public function handle(CurrencyRepository $currencyRepository)
    {
        $country = $this->country;
        $country->name_official = Arr::get($this->data, 'name_official');
        $country->name_common = Arr::get($this->data, 'name_common');
        $country->alpha_2_code = Arr::get($this->data, 'alpha_2_code');
        $country->alpha_3_code = Arr::get($this->data, 'alpha_3_code');
        $country->region = Arr::get($this->data, 'region');
        $country->subregion = Arr::get($this->data, 'subregion');
        $country->save();

        $currencies = Collection::wrap(Arr::get($this->data, 'currencies'))
            ->map(function ($currencyCode) use ($currencyRepository) {
                return $currencyRepository->firstForCode($currencyCode);
            })
            ->filter()
            ->map(function (Currency $currency) {
                return $currency->id;
            });

        $country->currencies()->sync($currencies);
    }
}
