<?php

namespace NathanDunn\Countries\Jobs;

use App\Countries\Jobs\CreateCountry;
use NathanDunn\Countries\CountryRepository;
use Illuminate\Bus\Dispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class SyncCountry implements ShouldQueue
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
    public function handle(CountryRepository $countryRepository, Dispatcher $jobDispatcher)
    {
        $country = $countryRepository->firstByAlpha3Code(Arr::get($this->data, 'alpha_3_code'));

        if (!$country) {
            $jobDispatcher->dispatch(new CreateCountry($this->data));

            return;
        }

        $jobDispatcher->dispatch(new UpdateCountry($country, $this->data));
    }
}
