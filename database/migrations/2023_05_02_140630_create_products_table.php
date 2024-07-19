<?php

use App\Models\Category;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('name');
            $table->string('barcode')->nullable();
            $table->integer('piece_count')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->integer('buying_price')->comment('Buying Price');
            $table->integer('selling_price')->comment('Selling Price');
            $table->integer('quantity');
            $table->integer('quantity_alert');
            $table->integer('tax')->nullable();
            $table->tinyInteger('tax_type')->nullable();
            $table->text('notes')->nullable();
            $table->string('product_image')->nullable();
            $table->foreignIdFor(Category::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignIdFor(Unit::class)->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
