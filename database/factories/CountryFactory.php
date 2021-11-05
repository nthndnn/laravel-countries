<?php

namespace NathanDunn\Countries\Database\Factories;

use NathanDunn\Countries\Country;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $countryName = $this->faker->country;

        do {
            $alpha3 = strtoupper($this->faker->lexify('???'));
            $alpha2 = substr($alpha3, 0, 2);
            $country = Country::where('alpha_2_code', $alpha2)
                ->orWhere('alpha_3_code', $alpha3)
                ->exists();
        } while ($country);

        return [
            'name_official' => $countryName,
            'name_common' => $countryName,
            'region' => $this->faker->words(3, true),
            'subregion' => $this->faker->words(3, true),
            'alpha_2_code' => $alpha2,
            'alpha_3_code' => $alpha3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
