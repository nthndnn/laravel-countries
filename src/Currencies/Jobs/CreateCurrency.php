<?php

namespace NathanDunn\Countries\Currencies\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NathanDunn\Countries\Currencies\CurrencyRepository;

class CreateCurrency extends CurrencyJob implements ShouldQueue
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
    public function handle(CurrencyRepository $currencyRepository)
    {
        $currency = $this->fillCurrency($currencyRepository->newInstance(), $this->data);
        $currency->save();
    }
}
