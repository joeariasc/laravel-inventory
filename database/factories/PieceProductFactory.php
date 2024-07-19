<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Piece;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class PieceProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'piece_id' => Piece::All()->random()->id,
            'product_id' => Product::All()->random()->id,
        ];
    }
}
