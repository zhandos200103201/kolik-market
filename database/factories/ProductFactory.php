<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Product::class;

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
            'count' => $this->faker->randomNumber(1),
            'is_used' => $this->faker->boolean,
            'views' => $this->faker->randomNumber(2),
        ];
    }
}
