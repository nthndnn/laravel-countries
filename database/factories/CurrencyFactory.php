<?php

namespace NathanDunn\Countries\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NathanDunn\Countries\Currencies\Currency;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $code = $this->faker->lexify('???');

            $currency = Currency::where('code', $code)->exists();
        } while ($currency);

        return [
            'code' => $code,
            'name' => $this->faker->words(3, true),
            'symbol' => '£',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
