<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nomEst' => $this->faker->word()
        ];
    }
}
