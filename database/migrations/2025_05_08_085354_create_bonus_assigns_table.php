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
        Schema::create('bonus_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('policy_master_id');
            $table->timestamps();
        
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('policy_master_id')->references('id')->on('policy_masters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonus_assigns');
    }
};
