<?php

namespace NathanDunn\Countries\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NathanDunn\Countries\Countries\Country;

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
            'capital' => [$this->faker->city()],
            'region' => $this->faker->words(3, true),
            'subregion' => $this->faker->words(3, true),
            'alpha_2_code' => $alpha2,
            'alpha_3_code' => $alpha3,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'independent' => $this->faker->boolean(),
            'un_member' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
