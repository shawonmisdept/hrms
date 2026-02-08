<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * মাইগ্রেশন চালান।
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Personal Information
            $table->string('emp_photo')->nullable();
            $table->string('salutation');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('dob');
            $table->string('gender');
            $table->string('religion')->nullable();
            $table->string('blood_group')->nullable();
            $table->foreignId('education_id')->nullable()->constrained('educations')->onDelete('set null'); // Assuming 'educations' table exists
            $table->string('id_number')->nullable();
            $table->string('id_type')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            // 'email' field is in 'users' table, not 'employees' table as per controller logic

            // Present Address
            $table->string('present_address')->nullable();
            $table->string('present_po')->nullable();
            $table->string('present_ps')->nullable();
            $table->string('present_zip')->nullable();
            $table->string('present_district')->nullable();
            $table->foreignId('present_upazila_id')->nullable()->constrained('upazilas')->onDelete('set null'); // Assuming 'upazilas' table exists
            $table->string('present_country')->nullable();

            // Permanent Address
            // 'same_as_present_address' is a form field, not a database column
            $table->string('permanent_address')->nullable();
            $table->string('permanent_po')->nullable();
            $table->string('permanent_ps')->nullable();
            $table->string('permanent_zip')->nullable();
            $table->string('permanent_district')->nullable();
            $table->foreignId('permanent_upazila_id')->nullable()->constrained('upazilas')->onDelete('set null'); // Assuming 'upazilas' table exists
            $table->string('permanent_country')->nullable();

            // Emergency Contact
            $table->string('guardian_number')->nullable();
            $table->string('ref_address')->nullable();

            // Marital Status & Children
            $table->string('marital_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_number')->nullable();
            $table->integer('no_of_children')->nullable()->default(0);

            // Official Information
            $table->string('employee_id')->unique();
            $table->string('employee_code')->nullable()->unique();
            $table->string('status');
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('set null'); // Assuming 'units' table exists
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade'); // Assuming 'departments' table exists
            $table->foreignId('designation_id')->constrained('designations')->onDelete('cascade'); // Assuming 'designations' table exists
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null'); // Assuming 'sections' table exists
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null'); // Assuming 'divisions' table exists
            $table->foreignId('line_id')->nullable()->constrained('lines')->onDelete('set null'); // Assuming 'lines' table exists
            $table->date('join_date');
            $table->foreignId('staff_category_id')->nullable()->constrained('staff_categories')->onDelete('set null'); // Assuming 'staff_categories' table exists
            $table->foreignId('salary_grade_id')->nullable()->constrained('salary_grades')->onDelete('set null'); // Assuming 'salary_grades' table exists
            $table->foreignId('shift_plan_id')->nullable()->constrained('shift_plans')->onDelete('set null'); // Assuming 'shift_plans' table exists
            $table->foreignId('leave_rule_id')->nullable()->constrained('policy_masters')->onDelete('set null'); // Assuming 'policy_masters' table exists
            $table->foreignId('attendance_rule')->nullable()->constrained('policy_masters')->onDelete('set null'); // Assuming 'policy_masters' table exists
            $table->string('employment_nature')->nullable();
            $table->longText('weekend_rule_id')->nullable(); // Storing as JSON string
            $table->foreignId('reporting_func_id')->nullable()->constrained('employees')->onDelete('set null'); // Self-referencing
            $table->foreignId('reporting_admin_id')->nullable()->constrained('employees')->onDelete('set null'); // Self-referencing

            // Bank Information
            $table->foreignId('bank_id')->nullable()->constrained('banks')->onDelete('set null'); // Assuming 'banks' table exists
            $table->foreignId('bank_branch_id')->nullable()->constrained('bank_branches')->onDelete('set null'); // Assuming 'bank_branches' table exists
            $table->string('account_number')->nullable();

            // Entitlements & Self Service
            $table->boolean('ent_overtime')->default(false);
            $table->boolean('ent_bonus')->default(false);
            $table->boolean('ent_offday_ot')->default(false);
            $table->boolean('ent_pf')->default(false);
            $table->date('provident_fund_date')->nullable();
            $table->string('provident_fund_account_no')->nullable();
            $table->boolean('ent_insurance')->default(false);
            $table->foreignId('insurance_id')->nullable()->constrained('insurances')->onDelete('set null'); // Assuming 'insurances' table exists
            $table->string('insurance_account')->nullable();
            $table->string('insurance_type')->nullable();
            $table->decimal('insurance_amount', 10, 2)->nullable();
            $table->boolean('consider_service_length')->default(false);
            $table->integer('service_length')->nullable();
            $table->string('service_length_unit')->nullable();

            $table->boolean('self_service')->default(false);

            // Educational Information
            $table->string('institute_name')->nullable();
            $table->string('exam_name')->nullable();
            $table->string('authority_name')->nullable();
            $table->string('exam_level')->nullable();
            $table->decimal('course_duration', 8, 2)->nullable();
            $table->integer('exam_year')->nullable();
            $table->string('major')->nullable();
            $table->string('certificate_number')->nullable();
            $table->decimal('cgpa', 3, 2)->nullable();
            $table->string('mark_avail')->nullable();
            $table->integer('total_mark')->nullable();

            // Employee Experiences
            $table->string('company_name')->nullable();
            $table->string('designation_experience')->nullable();
            $table->string('country_experience')->nullable();
            $table->string('city_experience')->nullable();
            $table->string('address_experience')->nullable();
            $table->date('start_date_experience')->nullable();
            $table->date('end_date_experience')->nullable();
            $table->decimal('start_salary', 15, 2)->nullable();
            $table->decimal('end_salary', 15, 2)->nullable();
            $table->string('currency')->nullable();
            $table->longText('responsibilities')->nullable();

            // User Documents
            $table->string('file_name')->nullable();
            $table->date('achievement_date')->nullable();
            $table->string('file_path')->nullable();

            $table->timestamps();
        });

        // Add foreign key to 'users' table for employee_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * মাইগ্রেশন রোলব্যাক করুন।
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('employee_id');
        });
        Schema::dropIfExists('employees');
    }
};
