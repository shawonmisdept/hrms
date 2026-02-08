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
        Schema::create('overtime_slabs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Holiday, After 7 PM
            $table->decimal('rate', 10, 2); // e.g., 300.00
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtime_slabs');
    }
};
