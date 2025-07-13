<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AlternatifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kriteria_id' => mt_rand(1, 9),
            'wood_id' => mt_rand(1, 9),
            'category_id' => mt_rand(1, 9),
            'alternative_value' => $this->faker->name(),
        ];
    }
}
