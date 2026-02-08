<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employee_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('company_name');
            $table->string('designation');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('start_salary')->nullable();
            $table->float('end_salary')->nullable();
            $table->string('currency')->nullable();
            $table->text('responsibilities')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('employee_experiences');
    }
};
