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
        Schema::create('policy_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_master_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('salary_head_id')
                ->constrained()
                ->onDelete('cascade');
            $table->enum('type', ['Fixed', 'Formula', 'Percentage']); // Type restriction
            $table->decimal('amount', 10, 2);            
            $table->integer('min_service_length');
            $table->integer('max_service_length');
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_details');
    }
};
