<?php

namespace NathanDunn\Countries\Currencies\Jobs;

use Illuminate\Bus\Dispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use NathanDunn\Countries\Currencies\CurrencyRepository;

class SyncCurrency implements ShouldQueue
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
    public function handle(CurrencyRepository $currencyRepository, Dispatcher $jobDispatcher)
    {
        $currency = $currencyRepository->firstByCode(Arr::get($this->data, 'code'));

        if (!$currency) {
            $jobDispatcher->dispatch(new CreateCurrency($this->data));

            return;
        }

        $jobDispatcher->dispatch(new UpdateCurrency($currency, $this->data));
    }
}
