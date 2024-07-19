<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Piece;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Delete directories
        Storage::deleteDirectory('public/products');
        Storage::deleteDirectory('public/users');
        Storage::deleteDirectory('public/pieces');

        //Create directories
        Storage::makeDirectory('public/products');
        Storage::makeDirectory('public/users');
        Storage::makeDirectory('public/pieces');

        //Create admin
        $admin = User::factory(1)->create([
            'role' => UserRole::ADMIN->value,
            'name' => 'Admin',
            'last_name' => 'Inventory',
            'email' => 'admin@inventory.com',
            'store_name' => null,
            'store_address' => null,
            'store_phone' => null,
            'store_email' => null,
        ])->first();

        //Create 5 assemblers
        User::factory(5)->create(['role' => UserRole::ASSEMBLER->value]);

        //Create 2 operators
        User::factory(2)->create(['role' => UserRole::OPERATOR->value]);

        //Create 10 Categories
        Category::factory(10)->create(['user_id' => $admin->id]);


        //Meters
        Unit::factory(1)->create([
            'name' => 'Meters',
            'short_code' => 'm',
            'user_id' => $admin->id
        ]);

        //Centimeters
        Unit::factory(1)->create([
            'name' => 'Centimeters',
            'short_code' => 'cm',
            'user_id' => $admin->id
        ]);

        $pieces = Piece::factory(20)->create(['user_id' => $admin->id]);

        $products = Product::factory(10)->create(['user_id' => $admin->id]);

        foreach ($products as $product) {
            $assignedPieces = $pieces->random(rand(1, 5));
            foreach ($assignedPieces as $piece) {
                DB::table('piece_product')->insert([
                    'id' => (string)Str::uuid(),
                    'piece_id' => $piece->id,
                    'product_id' => $product->id,
                ]);
            }
        }

        Customer::factory(15)->create(['user_id' => $admin->id]);

        Supplier::factory(15)->create(['user_id' => $admin->id]);
    }
}
