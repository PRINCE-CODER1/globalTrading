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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer_suppliers');
            $table->foreignId('lead_status_id')->constrained('lead_statuses');   
            $table->foreignId('lead_source_id')->constrained('lead_sources');  
            $table->foreignId('segment_id')->constrained('segments');        
            $table->foreignId('sub_segment_id')->constrained('segments'); 
            $table->date('expected_date')->nullable();
            $table->foreignId('assigned_to')->constrained('users');  
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
