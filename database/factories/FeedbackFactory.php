<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feedback>
 */
final class FeedbackFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->title,
            'score' => $this->faker->randomFloat(1),
        ];
    }
}
