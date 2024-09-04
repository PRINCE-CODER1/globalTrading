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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_no')->unique(); 
            $table->foreignId('supplier_id')->constrained('customer_suppliers')->onDelete('cascade'); 
            $table->date('purchase_date')->default(DB::raw('CURRENT_DATE')); // Purchase Date
            $table->string('ref_no')->nullable(); // Reference Number
            $table->string('destination')->nullable(); // Destination
            $table->string('received_through')->nullable(); // Received Through
            $table->string('gr_no')->nullable(); // G.R. No.
            $table->date('gr_date')->nullable(); // G.R. Date
            $table->decimal('weight', 10, 2)->nullable(); // Weight
            $table->integer('no_of_boxes')->nullable(); // No. of Boxes
            $table->string('vehicle_no')->nullable(); // Vehicle No
            $table->foreignId('branch_id')->constrained('branches'); // Link to branches table
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->nullable(); // Link to purchase orders table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // Created at and Updated 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
