<?php

namespace NathanDunn\Countries\Currencies\Jobs;

use Illuminate\Bus\Dispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NathanDunn\Countries\Currencies\Currency;
use NathanDunn\Countries\Currencies\CurrencyRepository;

class UpdateCurrency extends CurrencyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Currency $currency;

    protected array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Currency $currency, array $data)
    {
        $this->currency = $currency;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CurrencyRepository $currencyRepository, Dispatcher $jobDispatcher)
    {
        $currency = $this->fillCurrency($this->currency, $this->data);
        $currency->save();
    }
}
