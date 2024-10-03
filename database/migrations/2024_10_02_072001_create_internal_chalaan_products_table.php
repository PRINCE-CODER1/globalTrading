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
        Schema::create('internal_chalaan_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internal_chalaan_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_godown_id')->constrained('godowns')->onDelete('cascade');
            $table->foreignId('to_godown_id')->constrained('godowns')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_chalaan_products');
    }
};
