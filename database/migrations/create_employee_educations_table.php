<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employee_educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('institute_name');
            $table->string('exam_name');
            $table->string('authority_name')->nullable();
            $table->string('exam_level')->nullable();
            $table->integer('course_duration')->nullable(); // in years
            $table->year('exam_year');
            $table->string('major')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('cgpa')->nullable();
            $table->float('mark_avail')->nullable();
            $table->float('total_mark');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('employee_educations');
    }
};
