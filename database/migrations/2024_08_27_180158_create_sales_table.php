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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_no')->unique();
            $table->foreignId('customer_id')->constrained('customer_suppliers')->onDelete('cascade');
            $table->date('sale_date');
            $table->string('ref_no')->nullable();
            $table->string('destination')->nullable();
            $table->string('dispatch_through')->nullable();
            $table->string('gr_no')->nullable();
            $table->date('gr_date')->nullable();
            $table->date('select_date')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->unsignedInteger('no_of_boxes')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_order_id')->constrained('sale_orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
