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
        Schema::create('salary_heads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('head_type')->nullable(); // enum optional
            $table->integer('sequence')->default(0);
            $table->string('sort_code')->nullable();
            $table->enum('perquisite', ['yes', 'no'])->default('no');
            $table->enum('disburse', ['yes', 'no'])->default('no');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_heads');
    }
};
