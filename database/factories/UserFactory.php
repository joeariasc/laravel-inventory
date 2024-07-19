<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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

        $userImageDir = storage_path('app/public/users');

        if (!File::exists($userImageDir)) {
            File::makeDirectory($userImageDir, 0755, true);
        }

        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement(UserRole::cases()),
            'last_name' => fake()->lastName(),
            'personal_id' => fake()->unique()->numerify('#########'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'store_name' => fake()->company(),
            'store_address' => fake()->address(),
            'store_phone' => fake()->phoneNumber(),
            'store_email' => fake()->email(),
            'photo' => fake()->image($userImageDir, 600, 350, 'people', false),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
