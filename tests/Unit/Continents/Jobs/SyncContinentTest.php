<?php

namespace NathanDunn\Countries\Tests\Unit\Continents\Jobs;

use Illuminate\Bus\Dispatcher;
use NathanDunn\Countries\Continents\ContinentRepository;
use NathanDunn\Countries\Continents\Jobs\SyncContinent;
use NathanDunn\Countries\Tests\TestCase;

class SyncContinentTest extends TestCase
{
    /** @test */
    public function continent_can_be_synced()
    {
        $continent = 'Europe';
        /** @var ContinentRepository $continentRepository * */
        $continentRepository = app(ContinentRepository::class);
        /** @var Dispatcher $dispstcher */
        $dispatcher = app(Dispatcher::class);

        (new SyncContinent($continent))->handle($continentRepository, $dispatcher);

        $this->assertDatabaseHas('continents', ['name' => $continent]);
    }
}