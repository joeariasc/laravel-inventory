<?php

namespace Database\Factories;

use App\Enums\ColombianBanks;
use App\Enums\SupplierType;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $supplierImageDir = storage_path('app/public/suppliers');

        if (!File::exists($supplierImageDir)) {
            File::makeDirectory($supplierImageDir, 0755, true);
        }
        return [
            'user_id' => User::all()->random()->id,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'address' => fake()->address(),
            'shop_name' => fake()->company(),
            'type' => fake()->randomElement(SupplierType::cases()),
            'photo' => fake()->image($supplierImageDir, 600, 350, 'people', false),
            'account_holder' => fake()->name(),
            'account_number' => fake()->randomNumber(8, true),
            'bank' => fake()->randomElement(ColombianBanks::cases()),
        ];
    }
}
