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
        Schema::create('customer_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('mobile_no');
            $table->text('address')->nullable();
            $table->string('customer_supplier');
            $table->string('gst_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('ip_address')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_suppliers');
    }
};
