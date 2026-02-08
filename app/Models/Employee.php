<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * যে অ্যাট্রিবিউটগুলো বাল্ক অ্যাসাইন করা যাবে।
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Personal Information
        'emp_photo',
        'salutation',
        'first_name',
        'middle_name',
        'last_name',
        'father_name',
        'mother_name',
        'dob',
        'gender',
        'religion',
        'blood_group',
        'education_id', // foreign key
        'id_number',
        'id_type',
        'phone',
        'mobile',

        // Present Address
        'present_address',
        'present_po',
        'present_ps',
        'present_zip',
        'present_district',
        'present_upazila_id', // foreign key
        'present_country',

        // Permanent Address
        'permanent_address',
        'permanent_po',
        'permanent_ps',
        'permanent_zip',
        'permanent_district',
        'permanent_upazila_id', // foreign key
        'permanent_country',

        // Emergency Contact
        'guardian_number',
        'ref_address',

        // Marital Status & Children
        'marital_status',
        'spouse_name',
        'spouse_number',
        'no_of_children',

        // Official Information
        'employee_id',
        'employee_code',
        'status',
        'unit_id', // foreign key
        'department_id', // foreign key
        'designation_id', // foreign key
        'section_id', // foreign key
        'division_id', // foreign key
        'line_id', // foreign key
        'join_date',
        'staff_category_id', // foreign key
        'salary_grade_id', // foreign key
        'shift_plan_id', // foreign key
        'leave_rule_id', // foreign key
        'attendance_rule', // foreign key (named 'attendance_rule' in migration)
        'employment_nature',
        'weekend_rule_id', // Storing as JSON string
        'reporting_func_id', // foreign key
        'reporting_admin_id', // foreign key

        // Bank Information
        'bank_id', // foreign key
        'bank_branch_id', // foreign key
        'account_number',

        // Entitlements & Self Service
        'ent_overtime',
        'ent_bonus',
        'ent_offday_ot',
        'ent_pf',
        'provident_fund_date',
        'provident_fund_account_no',
        'ent_insurance',
        'insurance_id', // foreign key
        'insurance_account',
        'insurance_type',
        'insurance_amount',
        'consider_service_length',
        'service_length',
        'service_length_unit',
        'self_service',

        // Educational Information
        'institute_name',
        'exam_name',
        'authority_name',
        'exam_level',
        'course_duration',
        'exam_year',
        'major',
        'certificate_number',
        'cgpa',
        'mark_avail',
        'total_mark',

        // Employee Experiences
        'company_name',
        'designation_experience',
        'country_experience',
        'city_experience',
        'address_experience',
        'start_date_experience',
        'end_date_experience',
        'start_salary',
        'end_salary',
        'currency',
        'responsibilities',

        // User Documents
        'file_name',
        'achievement_date',
        'file_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * যে অ্যাট্রিবিউটগুলো সিরিয়ালাইজেশনের জন্য লুকানো উচিত।
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password', // Employee মডেলে পাসওয়ার্ড থাকে না, এটি User মডেলে থাকে।
    ];

    /**
     * The attributes that should be cast.
     * যে অ্যাট্রিবিউটগুলো নির্দিষ্ট ডেটা টাইপে কাস্ট করা উচিত।
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dob' => 'date',
        'join_date' => 'date',
        'provident_fund_date' => 'date',
        'start_date_experience' => 'date',
        'end_date_experience' => 'date',
        'achievement_date' => 'date',
        'ent_overtime' => 'boolean',
        'ent_bonus' => 'boolean',
        'ent_offday_ot' => 'boolean',
        'ent_pf' => 'boolean',
        'ent_insurance' => 'boolean',
        'consider_service_length' => 'boolean',
        'self_service' => 'boolean',
        'weekend_rule_id' => 'array', // JSON স্ট্রিং হিসাবে সংরক্ষিত হয়, তাই অ্যারেতে কাস্ট করুন
        'course_duration' => 'float', // decimal(8,2) -> float
        'cgpa' => 'float', // decimal(3,2) -> float
        'insurance_amount' => 'float', // decimal(10,2) -> float
        'start_salary' => 'float', // decimal(15,2) -> float
        'end_salary' => 'float', // decimal(15,2) -> float
        'no_of_children' => 'integer',
        'service_length' => 'integer',
        'exam_year' => 'integer',
        'total_mark' => 'integer',
    ];
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
    public function education(): BelongsTo
    {
        return $this->belongsTo(Education::class);
    }
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
    public function line(): BelongsTo
    {
        return $this->belongsTo(Line::class);
    }
    public function staffCategory(): BelongsTo
    {
        return $this->belongsTo(StaffCategory::class);
    }
    public function salaryGrade(): BelongsTo
    {
        return $this->belongsTo(SalaryGrade::class);
    }
    public function shiftPlan(): BelongsTo
    {
        return $this->belongsTo(ShiftPlan::class);
    }
    public function leaveRule(): BelongsTo
    {
        return $this->belongsTo(PolicyMaster::class, 'leave_rule_id');
    }
    public function attendanceRule(): BelongsTo
    {
        return $this->belongsTo(PolicyMaster::class, 'attendance_rule'); // এখানে 'attendance_rule' কলামের নাম ব্যবহার করা হয়েছে
    }
    public function weekendRules()
    {
        return PolicyMaster::whereIn('id', $this->weekend_rule_id ?? [])->get();
    }
   public function reportingFunctional(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'reporting_func_id');
    }
    public function reportingAdmin(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'reporting_admin_id');
    }
   public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
 public function bankBranch(): BelongsTo
    {
        return $this->belongsTo(BankBranch::class);
    }
   public function insurance(): BelongsTo
    {
        return $this->belongsTo(Insurance::class);
    }
   public function upazilaPresent(): BelongsTo
    {
        return $this->belongsTo(Upazila::class, 'present_upazila_id');
    }

    public function upazilaPermanent(): BelongsTo
    {
        return $this->belongsTo(Upazila::class, 'permanent_upazila_id');
    }
    public function getPhotoUrlAttribute()
    {
        if ($this->emp_photo) {
            return asset('storage/employee_photos/' . $this->emp_photo);
        }
        return null;  // অথবা ডিফল্ট ছবি URL দিতে পারো
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

