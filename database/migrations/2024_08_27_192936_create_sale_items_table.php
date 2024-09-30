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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade'); 
            $table->foreignId('product_id')->constrained('products'); 
            $table->unsignedInteger('quantity'); 
            $table->decimal('price', 8, 2); 
            $table->decimal('discount', 5, 2)->default(0); 
            $table->foreignId('godown_id')->constrained('godowns'); 
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};