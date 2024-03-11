<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'role_id' => $this->faker->randomNumber(9),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => $this->faker->password,
            'status' => $this->faker->boolean,
            'photo' => $this->faker->image,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->unique()->address,
            'remember_token' => Str::random(10),
        ];
    }
}
