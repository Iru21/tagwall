<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends User
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'password' => 'password',
            'is_admin' => false,
            'activated_at' => fake()->dateTimeBetween('-3 year'),
            'created_at' => fake()->dateTimeBetween('-3 year'),
        ];
    }
}
