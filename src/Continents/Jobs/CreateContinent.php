<?php

namespace NathanDunn\Countries\Continents\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NathanDunn\Countries\Continents\ContinentRepository;

class CreateContinent implements ShouldQueue
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
    public function handle(ContinentRepository $continentRepository)
    {
        $continent = $continentRepository->newInstance();
        $continent->name = $this->continent;
        $continent->save();
    }
}
