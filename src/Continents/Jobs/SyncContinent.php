<?php

namespace NathanDunn\Countries\Continents\Jobs;

use Illuminate\Bus\Dispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NathanDunn\Countries\Continents\ContinentRepository;

class SyncContinent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $continent;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $continent)
    {
        $this->continent = $continent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        ContinentRepository $continentRepository,
        Dispatcher $jobDispatcher
    )
    {
        $continent = $continentRepository->firstByName($this->continent);

        if (!$continent) {
            $jobDispatcher->dispatch(new CreateContinent($this->continent));
        }
    }
}
