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
    Schema::create('insurances', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('coverage_amount', 12, 2)->nullable();
        $table->decimal('premium', 12, 2)->nullable();
        $table->string('provider_name')->nullable();
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->boolean('status')->default(1);
        $table->unsignedBigInteger('created_by')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
