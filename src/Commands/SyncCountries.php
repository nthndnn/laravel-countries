<?php

namespace NathanDunn\Countries\Commands;

use Illuminate\Bus\Dispatcher;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
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
     */
    public function handle()
    {
        $response = Http::get('https://restcountries.com/v3.1/all');
        $countries = $response->collect();

        $countries->reduce(function ($currencies, $country) {
            $countryCurrencies = Collection::wrap(Arr::get($country, 'currencies'))
                ->map(function ($currency, $code) {
                    return array_merge($currency, ['code' => $code]);
                });

            return $currencies->concat($countryCurrencies);
        }, new Collection)
            ->unique('code')
            ->each(function ($currency) {
                $this->line(sprintf('Syncing currency %s...', Arr::get($currency, 'name')));

                $this->jobDispatcher->dispatch(new SyncCurrency($currency));
            });

        $response->collect()->each(function ($country) {
            $this->jobDispatcher->dispatch(new SyncCountry($country));
            $this->line(sprintf('Syncing %s...', Arr::get($country, 'name.common')));
        });

        $this->info('Country sync complete!');

        return 0;
    }
}
