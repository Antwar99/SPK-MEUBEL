<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wood>
 */
class WoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ID Kayu' => $this->faker->numerify('#####'),
            'Nama Kayu' => $this->faker->name(),
            'Supplier' => $this->faker->company(),
            'Kategori Kayu' => mt_rand(1, 9),
        ];
    }
}
