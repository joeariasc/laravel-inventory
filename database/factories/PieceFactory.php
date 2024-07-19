<?php

namespace Database\Factories;

use App\Models\Piece;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends Factory<Piece>
 */
class PieceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pieceImageDir = storage_path('app/public/pieces');

        if (!File::exists($pieceImageDir)) {
            File::makeDirectory($pieceImageDir, 0755, true);
        }

        return [
            'user_id' => User::all()->random()->id,
            'name' => fake()->words(4, true),
            'code' => fake()->unique()->word(),
            'description' => null,
            'material' => null,
            'piece_image' => fake()->image($pieceImageDir, 600, 350, 'products', false),
        ];
    }
}
