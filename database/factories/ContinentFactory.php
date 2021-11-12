<?php

namespace NathanDunn\Countries\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NathanDunn\Countries\Continents\Continent;

class ContinentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Continent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
