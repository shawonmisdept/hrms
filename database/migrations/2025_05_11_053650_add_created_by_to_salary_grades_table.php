<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToSalaryGradesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('salary_grades', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable();  // Add created_by field
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');  // Foreign key to users table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salary_grades', function (Blueprint $table) {
            $table->dropForeign(['created_by']);  // Drop foreign key
            $table->dropColumn('created_by');  // Drop created_by column
        });
    }
}
