<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
final class ServiceFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->title,
            'description' => $this->faker->sentence,
            'photo' => $this->faker->image,
            'price' => $this->faker->randomNumber(3),
            'views' => $this->faker->randomNumber(2),
        ];
    }
}
