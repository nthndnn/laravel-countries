<?php

namespace NathanDunn\Countries\Console\Commands;

use NathanDunn\Countries\Country;
use NathanDunn\Countries\Jobs\SyncCountry;
use Illuminate\Bus\Dispatcher;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

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

        $response->collect()->each(function ($country) {
            $currencies = collect(Arr::get($country, 'currencies'))
                ->map(function ($currency, $currencyCode) {
                    return $currencyCode;
                })
                ->flatten()
                ->toArray();

            $data = [
                'name_official' => Arr::get($country, 'name.official'),
                'name_common' => Arr::get($country, 'name.common'),
                'region' => Arr::get($country, 'region'),
                'subregion' => Arr::get($country, 'subregion'),
                'alpha_2_code' => Arr::get($country, 'cca2'),
                'alpha_3_code' => Arr::get($country, 'cca3'),
                'currencies' => $currencies,
            ];

            $this->jobDispatcher->dispatch(new SyncCountry($data));
            $this->line(sprintf('Syncing %s...', Arr::get($data, 'name_common')));
        });

        $this->info('Country sync complete!');

        return 0;
    }
}
