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
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('stock_transfer_no')->unique();
            $table->foreignId('from_branch_id')->constrained('branches')->onDelete('cascade');
            $table->date('stock_transfer_date');
            $table->string('ref_no')->nullable();
            $table->string('destination')->nullable();
            $table->string('dispatch_through')->nullable();
            $table->string('gr_no')->nullable();
            $table->date('gr_date')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->unsignedInteger('no_of_boxes')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->foreignId('to_branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('to_godown_id')->constrained('godowns')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_tranfers');
    }
};
