<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => fake()->randomElement([1, 2, 3, 4, 5]),
            'purchase_date' => now(),
            'purchase_no' => fake()->randomElement([1, 2, 3, 4, 5]),
            'purchase_status' => fake()->randomElement([0, 1]),
            'total_amount' => fake()->randomNumber(2),
            'quantity_alert' => fake()->randomElement([5, 10, 15]),
            'created_by' => User::all()->random()->id,
        ];
    }
}
