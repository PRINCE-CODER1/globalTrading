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
        Schema::create('master_numberings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('financial_year')->unique();
            $table->string('sale_order_format')->nullable();
            $table->string('purchase_order_format')->nullable();
            $table->string('in_transit_order_format')->nullable();
            $table->string('challan_format')->nullable();
            $table->string('sale_format')->nullable();
            $table->string('purchase_format')->nullable();
            $table->string('stock_transfer_format')->nullable();
            $table->string('branch_to_workshop_transfer_format')->nullable();
            $table->string('workshop_to_branch_transfer_format')->nullable();
            $table->string('branch_to_customer_transfer_format')->nullable();
            $table->string('customer_to_branch_transfer_format')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_numberings');
    }
};
