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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('product_description')->nullable();
            $table->foreignId('product_category_id')->constrained('stock_categories');  
            $table->decimal('tax', 8, 2)->nullable(); 
            $table->string('hsn_code');
            $table->decimal('price', 10, 2);
            $table->string('product_code')->unique();
            $table->integer('opening_stock')->default(0);
            $table->integer('reorder_stock')->default(0);
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('godown_id')->constrained('godowns'); 
            $table->foreignId('unit_id')->constrained('unit_of_measurements'); 
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('modified_by')->nullable()->constrained('users'); 
            $table->timestamp('received_at')->nullable(); 
            $table->timestamps();
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
