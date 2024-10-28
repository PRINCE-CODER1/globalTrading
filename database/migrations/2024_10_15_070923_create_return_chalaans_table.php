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
        Schema::create('return_chalaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('external_chalaan_id')->constrained('external_chalaans')->onDelete('cascade');
            $table->string('return_reference_id');
            $table->foreignId('returned_by')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_chalaans');
    }
};
