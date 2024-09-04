<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade'); // Link to purchases table
            $table->foreignId('product_id')->constrained('products'); // Link to products table
            $table->integer('quantity'); // Quantity
            $table->decimal('price', 10, 2); // Price
            $table->decimal('discount', 5, 2)->nullable(); // Discount (%)
            $table->foreignId('godown_id')->constrained('godowns'); // Link to godowns table
            $table->decimal('sub_total', 10, 2); // Sub Total
            $table->timestamps(); // Created at and Updated at
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
