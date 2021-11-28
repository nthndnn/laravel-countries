<?php

namespace NathanDunn\Countries\Tests\Unit\Continents\Jobs;

use NathanDunn\Countries\Continents\ContinentRepository;
use NathanDunn\Countries\Continents\Jobs\CreateContinent;
use NathanDunn\Countries\Tests\TestCase;

class CreateContinentTest extends TestCase
{
    /** @test */
    public function continent_can_be_created()
    {
        $continent = 'Europe';
        /** @var ContinentRepository $continentRepository * */
        $continentRepository = app(ContinentRepository::class);

        (new CreateContinent($continent))->handle($continentRepository);

        $this->assertDatabaseHas('continents', ['name' => $continent]);
    }
}