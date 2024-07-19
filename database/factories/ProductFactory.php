<?php

namespace Database\Factories;

use App\Enums\TaxType;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productImageDir = storage_path('app/public/products');

        if (!File::exists($productImageDir)) {
            File::makeDirectory($productImageDir, 0755, true);
        }

        return [
            'name' => fake()->words(4, true),
            'barcode' => fake()->ean8(),
            'buying_price' => fake()->randomNumber(2),
            'selling_price' => fake()->randomNumber(2),
            'quantity' => fake()->randomNumber(2),
            'quantity_alert' => fake()->randomElement([5, 10, 15]),
            'tax' => fake()->randomElement([5, 10, 15, 20, 25]),
            'tax_type' => fake()->randomElement(TaxType::cases()),
            'notes' => null,
            'product_image' => fake()->image($productImageDir, 600, 350, 'products', false),
            'category_id' => Category::all()->random()->id,
            'unit_id' => Unit::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
