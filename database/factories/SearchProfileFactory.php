<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SearchProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fields = json_encode(
            [
                // 'area' => $this->faker->randomNumber(),
                // 'yearOfConstruction' => $this->faker->year(),
                // 'rooms' => $this->faker->numberBetween(1, 50),
                // 'heatingType' => 'gas',
                // 'parking' => true,
                // 'returnActual' => $this->faker->randomNumber(),
                'price' => $this->faker->randomFloat()
            ]
        );
        return [
            'name' => $this->faker->sentence(),
            'propertyType' => $this->faker->uuid(),
            'searchFields' => json_decode($fields)
        ];
    }
}
