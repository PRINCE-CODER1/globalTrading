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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_no');
            $table->date('date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The user who created the order
            $table->foreignId('supplier_id')->nullable()->constrained('customer_suppliers')->onDelete('cascade'); // Supplier
            $table->string('supplier_sale_order_no')->nullable();
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade'); // Agent/User
            $table->foreignId('segment_id')->constrained()->onDelete('cascade'); // Segment
            $table->foreignId('order_branch_id')->constrained('branches')->onDelete('cascade'); // Order Branch
            $table->foreignId('delivery_branch_id')->constrained('branches')->onDelete('cascade'); // Delivery Branch
            $table->foreignId('customer_id')->nullable()->constrained('customer_suppliers')->onDelete('cascade'); // Customer
            $table->string('customer_sale_order_no')->nullable();
            $table->date('customer_sale_order_date')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
