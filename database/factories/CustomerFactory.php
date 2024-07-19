<?php

namespace Database\Factories;

use App\Enums\ColombianBanks;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerImageDir = storage_path('app/public/customers');

        if (!File::exists($customerImageDir)) {
            File::makeDirectory($customerImageDir, 0755, true);
        }
        return [
            'user_id' => User::all()->random()->id,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'address' => fake()->address(),
            'account_holder' => fake()->name(),
            'account_number' => fake()->randomNumber(8, true),
            'bank' => fake()->randomElement(ColombianBanks::cases()),
            'photo' => fake()->image($customerImageDir, 600, 350, 'people', false),
        ];
    }
}
