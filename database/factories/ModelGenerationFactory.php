<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ModelGeneration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ModelGeneration>
 */
final class ModelGenerationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_year' => $this->faker->year,
            'end_year' => $this->faker->year,
        ];
    }
}
