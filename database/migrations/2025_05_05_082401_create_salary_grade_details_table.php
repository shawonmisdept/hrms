<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryGradeDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('salary_grade_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained('salary_grades')->onDelete('cascade'); // Ensure table name matches
            $table->foreignId('head_id')->constrained('salary_heads')->onDelete('cascade'); // Ensure table name matches
            $table->boolean('fixed')->default(0); // 1 = Yes, 0 = No
            $table->enum('type', ['F', 'M', '%'])->nullable(); // F = Fixed, M = Formula, % = Percentage
            $table->text('formula')->nullable(); // Only if type = M
            $table->foreignId('parent_head_id')->nullable()->constrained('salary_heads')->onDelete('set null'); // Only for type = %
            $table->decimal('parent_head_value', 10, 2)->nullable(); // % or amount
            $table->boolean('is_higher')->default(0); // 1 = Yes, 0 = No
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_grade_details');
    }
}
