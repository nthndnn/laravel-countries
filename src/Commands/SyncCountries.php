<?php

namespace NathanDunn\Countries\Commands;

use Exception;
use Illuminate\Bus\Dispatcher;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use NathanDunn\Countries\Continents\Jobs\SyncContinent;
use NathanDunn\Countries\Countries\Jobs\SyncCountry;
use NathanDunn\Countries\Currencies\Jobs\SyncCurrency;

class SyncCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countries:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync countries from source';

    /**
     * @var Dispatcher $jobDispatcher
     */
    protected Dispatcher $jobDispatcher;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Dispatcher $jobDispatcher)
    {
        parent::__construct();

        $this->jobDispatcher = $jobDispatcher;
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        $response = Http::get('https://restcountries.com/v3.1/all');
        $countries = $response->collect();

        if ($response->serverError()) {
            throw new Exception('Fetching from API failed.');
        }

        $this->syncContinents($countries);
        $this->syncCurrencies($countries);
        $this->syncCountries($countries);

        $this->info('Country sync complete!');

        return 0;
    }

    protected function syncContinents(Collection $countries): void
    {
        $countries
            ->map(function ($country) {
                $continents = Arr::get($country, 'continents');

                return Arr::first($continents);
            })
            ->unique()
            ->sort()
            ->each(function ($continent) {
                $this->jobDispatcher->dispatchSync(new SyncContinent($continent));

                $this->line(sprintf('Syncing continent %s...', $continent));
            });
    }

    protected function syncCurrencies(Collection $countries): void
    {
        $countries
            ->reduce(function ($currencies, $country) {
                $countryCurrencies = Collection::wrap(Arr::get($country, 'currencies'))
                    ->map(function ($currency, $code) {
                        return array_merge($currency, ['code' => $code]);
                    });

                return $currencies->concat($countryCurrencies);
            }, new Collection)
            ->unique('code')
            ->sortBy('code')
            ->each(function ($currency) {
                $this->jobDispatcher->dispatchSync(new SyncCurrency($currency));

                $this->line(sprintf('Syncing currency %s...', Arr::get($currency, 'name')));
            });
    }

    protected function syncCountries(Collection $countries)
    {
        $countries->each(function ($country) {
            $this->jobDispatcher->dispatch(new SyncCountry($country));

            $this->line(sprintf('Syncing %s...', Arr::get($country, 'name.common')));
        });
    }
}
