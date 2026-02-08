<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Unit;
use App\Models\StaffCategory;
use App\Models\SalaryGrade;
use App\Models\Department;
use App\Models\Designation;
use App\Models\PolicyMaster; // WeekendRule, LeaveRule, AttendanceRule এর জন্য
use App\Models\ShiftPlan;
use App\Models\District;
use App\Models\Education;
use App\Models\Country;
use App\Models\User;
use App\Models\Line;
use App\Models\Section;
use App\Models\Division;
use App\Models\Upazila;
use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Carbon ব্যবহার করার জন্য ইম্পোর্ট করুন

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * রিসোর্সের একটি তালিকা প্রদর্শন করুন।
     */
    public function index(Request $request)
        {
            // Fetch filter dropdown data
            $units = Unit::all();
            $departments = Department::all();
            $designations = Designation::all();
            $sections = Section::all();
            $divisions = Division::all();
            $lines = Line::all();
            $staffCategories = StaffCategory::all();
            $salaryGrades = SalaryGrade::all();
            $shiftPlans = ShiftPlan::all();

            // Query employees with filters
            $query = Employee::query();

            if ($request->unit) {
                $query->where('unit_id', $request->unit);
            }
            if ($request->department) {
                $query->where('department_id', $request->department);
            }
            if ($request->designation) {
                $query->where('designation_id', $request->designation);
            }
            if ($request->section) {
                $query->where('section_id', $request->section);
            }
            if ($request->division) {
                $query->where('division_id', $request->division);
            }
            if ($request->line) {
                $query->where('line_id', $request->line);
            }
            if ($request->gender) {
                $query->where('gender', $request->gender);
            }
            if ($request->staff_category) {
                $query->where('staff_category_id', $request->staff_category);
            }
            if ($request->salary_grade) {
                $query->where('salary_grade_id', $request->salary_grade);
            }
            if ($request->shift_plan) {
                $query->where('shift_plan_id', $request->shift_plan);
            }
            if ($request->status) {
                $query->where('status', $request->status);
            }
            // Apply search
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', $searchTerm)
                  ->orWhere('last_name', 'LIKE', $searchTerm)
                  ->orWhere('employee_code', 'LIKE', $searchTerm)
                  ->orWhereHas('department', function($departmentQuery) use ($searchTerm) {
                      $departmentQuery->where('name', 'LIKE', $searchTerm);
                  })
                  ->orWhereHas('designation', function($designationQuery) use ($searchTerm) {
                      $designationQuery->where('name', 'LIKE', $searchTerm);
                  });
            });
            }

            $perPage = $request->per_page ?: 10;

            $employees = $query->paginate($perPage)->withQueryString();

            return view('employees.index', compact('employees', 'units', 'departments', 'designations', 'sections', 'divisions', 'lines', 'staffCategories', 'salaryGrades', 'shiftPlans'));
        }


    /**
     * Show the form for creating a new employee.
     * একটি নতুন কর্মচারী তৈরির জন্য ফর্মটি দেখান।
     */
    public function create()
    {
        // ড্রপডাউন ফিল্ডের জন্য প্রয়োজনীয় ডেটা লোড করুন
        $units = Unit::all();
        $weekendRules = PolicyMaster::where('type', 'weekend_rule')->get();
        $leaveRules = PolicyMaster::where('type', 'leave_rule')->get();
        $attendanceRules = PolicyMaster::where('type', 'attendance_rule')->get();

        $employees = Employee::all(); // রিপোর্টিং ফাংশনাল/অ্যাডমিন এর জন্য
        $staffCategories = StaffCategory::all();
        $salaryGrades = SalaryGrade::all();
        $departments = Department::all();
        $designations = Designation::all();
        $shiftPlans = ShiftPlan::all();
        $districts = District::all();
        $countries = Country::all();
        $insurances = Insurance::all();

        $sections = Section::all();
        $divisions = Division::all();
        $lines = Line::all();
        $educations = Education::all();
        $upazilas = Upazila::all();
        $banks = Bank::all();
        $bankBranches = BankBranch::all();

        return view('employees.create', compact(
            'countries', 'districts', 'departments', 'designations', 'units',
            'staffCategories', 'salaryGrades', 'shiftPlans', 'leaveRules',
            'weekendRules', 'attendanceRules', 'employees',
            'sections', 'divisions', 'lines', 'educations', 'upazilas',
            'banks', 'bankBranches', 'insurances',
        ));
    }

    /**
     * Store a newly created employee in storage.
     * স্টোরেজে একটি নতুন তৈরি কর্মচারী সংরক্ষণ করুন।
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Personal Information
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB Max, blade এ 5MB ছিল, এখানে 2MB করা হলো
            'salutation' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'dob' => 'required|date_format:m/d/Y', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'gender' => 'required|string|in:Male,Female,Other',
            'religion' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'education_id' => 'nullable|exists:educations,id', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'id_number' => 'nullable|string|max:255',
            'id_type' => 'nullable|string|in:NID,Passport,Birth Certificate',
            'phone' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            // 'email' => 'nullable|email|max:255', // এই ফিল্ডটি employee টেবিলে না থাকলে বাদ দিন, User টেবিলে email আছে

            // Present Address
            'present_address' => 'nullable|string|max:255',
            'present_po' => 'nullable|string|max:255',
            'present_ps' => 'nullable|string|max:255',
            'present_zip' => 'nullable|string|max:255',
            'present_district' => 'nullable|string|max:255',
            'present_upazila_id' => 'nullable|exists:upazilas,id', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'present_country' => 'nullable|string|max:255',

            // Permanent Address
            'same_as_present_address' => 'nullable|boolean', // Checkbox value
            'permanent_address' => 'nullable|string|max:255',
            'permanent_po' => 'nullable|string|max:255',
            'permanent_ps' => 'nullable|string|max:255',
            'permanent_zip' => 'nullable|string|max:255',
            'permanent_district' => 'nullable|string|max:255',
            'permanent_upazila_id' => 'nullable|exists:upazilas,id', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'permanent_country' => 'nullable|string|max:255',

            // Emergency Contact
            'guardian_number' => 'nullable|string|max:255',
            'ref_address' => 'nullable|string|max:255',

            // Marital Status & Children
            'marital_status' => 'nullable|string|in:Single,Married,Divorced,Widowed',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_number' => 'nullable|string|max:255',
            'no_of_children' => 'nullable|integer|min:0',

            // Official Information
            'employee_id' => 'required|string|max:255|unique:employees,employee_id',
            'employee_code' => 'nullable|string|max:255|unique:employees,employee_code',
            'status' => 'required|string|in:Active,Pending,Inactive,Blocked,Suspended', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'unit_id' => 'nullable|exists:units,id',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'section_id' => 'nullable|exists:sections,id', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'division_id' => 'nullable|exists:divisions,id', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'line_id' => 'nullable|exists:lines,id', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'join_date' => 'required|date_format:m/d/Y', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'staff_category_id' => 'nullable|exists:staff_categories,id',
            'salary_grade_id' => 'nullable|exists:salary_grades,id',
            'shift_plan_id' => 'nullable|exists:shift_plans,id',
            'leave_rule_id' => 'nullable|exists:policy_masters,id',
            'attendance_rule' => 'nullable|exists:policy_masters,id',
            'employment_nature' => 'nullable|string|in:Permanent,Temporary,Provision,Contractual',
            'weekend_rule_ids' => 'nullable|array',
            'weekend_rule_ids.*' => 'exists:policy_masters,id',
            'reporting_func_id' => 'nullable|exists:employees,id',
            'reporting_admin_id' => 'nullable|exists:employees,id',

            // Bank Information
            'bank_id' => 'nullable|exists:banks,id',
            'bank_branch_id' => 'nullable|exists:bank_branches,id',
            'account_number' => 'nullable|string|max:255',

            // Entitlements & Self Service
            'ent_overtime' => 'boolean',
            'ent_bonus' => 'boolean',
            'ent_offday_ot' => 'boolean',
            'ent_pf' => 'boolean',
            'provident_fund_date' => 'nullable|date_format:m/d/Y', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'provident_fund_account_no' => 'nullable|string|max:255',
            'ent_insurance' => 'boolean', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'insurance_id' => 'nullable|exists:insurances,id', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'insurance_account' => 'nullable|string|max:255',
            'insurance_type' => 'nullable|string|max:255',
            'insurance_amount' => 'nullable|numeric',
            'consider_service_length' => 'boolean', // Blade এর সাথে সামঞ্জস্যপূর্ণ
            'service_length' => 'nullable|integer|min:0',
            'service_length_unit' => 'nullable|string|in:Month,Year',

            'self_service' => 'boolean',
            // Login Information for User table (conditional required based on self_service)
            'username' => [
                Rule::requiredIf($request->boolean('self_service')),
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                Rule::requiredIf($request->boolean('self_service')),
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'password_confirmation' => 'nullable', // শুধুমাত্র নিশ্চিতকরণের জন্য

            // Educational Information
            'institute_name' => 'nullable|string|max:255',
            'exam_name' => 'nullable|string|max:255',
            'authority_name' => 'nullable|string|max:255',
            'exam_level' => 'nullable|string|max:255',
            'course_duration' => 'nullable|numeric|min:0',
            'exam_year' => 'nullable|integer|digits:4|min:1900|max:' . (date('Y') + 5),
            'major' => 'nullable|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'cgpa' => 'nullable|numeric|between:0,5.00',
            'mark_avail' => 'nullable|string|in:Yes,No',
            'total_mark' => 'nullable|integer|min:0',

            // Employee Experiences
            'company_name' => 'nullable|string|max:255',
            'designation_experience' => 'nullable|string|max:255',
            'country_experience' => 'nullable|string|max:255',
            'city_experience' => 'nullable|string|max:255',
            'address_experience' => 'nullable|string|max:255',
            'start_date_experience' => 'nullable|date_format:m/d/Y',
            'end_date_experience' => 'nullable|date_format:m/d/Y|after_or_equal:start_date_experience',
            'start_salary' => 'nullable|numeric|min:0',
            'end_salary' => 'nullable|numeric|min:0|gte:start_salary',
            'currency' => 'nullable|string|max:255',
            'responsibilities' => 'nullable|string',

            // User Documents
            'file_name' => 'nullable|string|max:255',
            'achievement_date' => 'nullable|date_format:m/d/Y',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,txt,xlsx,csv|max:5120', // 5MB Max
        ]);

        // Handle file uploads
        $validatedData['emp_photo'] = null; // emp_photo ব্যবহার করুন, কারণ Blade এ emp_photo আছে
        if ($request->hasFile('photo')) {
            $validatedData['emp_photo'] = $request->file('photo')->store('employee_photos', 'public');
            $validatedData['emp_photo'] = basename($validatedData['emp_photo']); // শুধু ফাইলের নাম সংরক্ষণ করুন
        }

        $validatedData['file_path'] = null;
        if ($request->hasFile('file_path')) {
            $validatedData['file_path'] = $request->file('file_path')->store('employee_documents', 'public');
            $validatedData['file_path'] = basename($validatedData['file_path']); // শুধু ফাইলের নাম সংরক্ষণ করুন
        }

        // Date formatting for database storage (YYYY-MM-DD)
        $dateFields = ['dob', 'join_date', 'provident_fund_date', 'start_date_experience', 'end_date_experience', 'achievement_date'];
        foreach ($dateFields as $field) {
            if (isset($validatedData[$field])) {
                $validatedData[$field] = Carbon::createFromFormat('m/d/Y', $validatedData[$field])->format('Y-m-d');
            }
        }

        // Permanent Address logic if "Same as Present Address" is checked
        if ($request->boolean('same_as_present_address')) {
            $validatedData['permanent_address'] = $validatedData['present_address'] ?? null;
            $validatedData['permanent_po'] = $validatedData['present_po'] ?? null;
            $validatedData['permanent_ps'] = $validatedData['present_ps'] ?? null;
            $validatedData['permanent_zip'] = $validatedData['present_zip'] ?? null;
            $validatedData['permanent_district'] = $validatedData['present_district'] ?? null;
            $validatedData['permanent_upazila_id'] = $validatedData['present_upazila_id'] ?? null;
            $validatedData['permanent_country'] = $validatedData['present_country'] ?? null;
        }

        // Weekend Rules handling (many-to-many) - Store as JSON string
        $validatedData['weekend_rule_id'] = json_encode($validatedData['weekend_rule_ids'] ?? []);
        unset($validatedData['weekend_rule_ids']); // মূল অ্যারে থেকে এটি বাদ দিন

        // Exclude user-related fields from employee data
        $employeeData = collect($validatedData)->except(['username', 'password', 'password_confirmation'])->toArray();

        // Create the Employee record
        $employee = Employee::create($employeeData);

        // Handle User creation for Self Service
        if ($request->boolean('self_service')) {
            User::create([
                'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
                'email' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'employee_id' => $employee->id, // Employee এর সাথে User কে লিঙ্ক করুন
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee created successfully!');
    }

    /**
     * Display the specified resource.
     * নির্দিষ্ট রিসোর্স প্রদর্শন করুন।
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        // Employee এর সাথে সম্পর্কিত সকল ডেটা লোড করুন
        $employee->load([
            'education', 'unit', 'department', 'designation', 'section', 'division', 'line',
            'staffCategory', 'salaryGrade', 'shiftPlan', 'leaveRule', 'attendanceRule',
            // 'weekendRules', // Removed eager loading for custom method
            'reportingFunctional', 'reportingAdmin', 'bank', 'bankBranch',
            'insurance', 'user', 'upazilaPresent', 'upazilaPermanent'
        ]);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     * নির্দিষ্ট রিসোর্স সম্পাদনা করার জন্য ফর্মটি দেখান।
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
{
    $units = Unit::all();
    $weekendRules = PolicyMaster::where('type', 'weekend_rule')->get();
    $leaveRules = PolicyMaster::where('type', 'leave_rule')->get();
    $attendanceRules = PolicyMaster::where('type', 'attendance_rule')->get();

    $employeesList = Employee::where('id', '!=', $employee->id)->get(); // নিজেকে বাদ দিয়ে
    $staffCategories = StaffCategory::all();
    $salaryGrades = SalaryGrade::all();
    $departments = Department::all();
    $designations = Designation::all();
    $shiftPlans = ShiftPlan::all();
    $districts = District::all();
    $countries = Country::all();
    $insurances = Insurance::all();

    $sections = Section::all();
    $divisions = Division::all();
    $lines = Line::all();
    $educations = Education::all();
    $upazilas = Upazila::all();
    $banks = Bank::all();
    $bankBranches = BankBranch::all();

    // রিলেশন লোড করা (ensure all relationships exist in Employee model)
    $employee->load([
        'unit', 'department', 'designation', 'section', 'division', 'line',
        'staffCategory', 'salaryGrade', 'shiftPlan', 'leaveRule', 'attendanceRule',
        'bank', 'bankBranch', 'insurance', 'user',
        'reportingFunctional', 'reportingAdmin',
        'upazilaPresent', 'upazilaPermanent',
        // যদি 'education' hasMany হয় তাহলে আলাদা করে পাঠানো হবে
    ]);

    $employeeEducations = $employee->education; // যদি hasMany থাকে

    return view('employees.edit', compact(
        'employee', 'employeeEducations',
        'countries', 'districts', 'departments', 'designations', 'units',
        'staffCategories', 'salaryGrades', 'shiftPlans', 'leaveRules',
        'weekendRules', 'attendanceRules', 'employeesList',
        'sections', 'divisions', 'lines', 'educations', 'upazilas',
        'banks', 'bankBranches', 'insurances'
    ));
}


    /**
     * Update the specified employee in storage.
     * স্টোরেজে নির্দিষ্ট কর্মচারী আপডেট করুন।
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            // Personal Information
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB Max
            'salutation' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'dob' => 'required|date_format:m/d/Y',
            'gender' => 'required|string|in:Male,Female,Other',
            'religion' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'education_id' => 'nullable|exists:educations,id',
            'id_number' => 'nullable|string|max:255',
            'id_type' => 'nullable|string|in:NID,Passport,Birth Certificate',
            'phone' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            // 'email' => 'nullable|email|max:255', // এই ফিল্ডটি employee টেবিলে না থাকলে বাদ দিন, User টেবিলে email আছে

            // Present Address
            'present_address' => 'nullable|string|max:255',
            'present_po' => 'nullable|string|max:255',
            'present_ps' => 'nullable|string|max:255',
            'present_zip' => 'nullable|string|max:255',
            'present_district' => 'nullable|string|max:255',
            'present_upazila_id' => 'nullable|exists:upazilas,id',
            'present_country' => 'nullable|string|max:255',

            // Permanent Address
            'same_as_present_address' => 'nullable|boolean',
            'permanent_address' => 'nullable|string|max:255',
            'permanent_po' => 'nullable|string|max:255',
            'permanent_ps' => 'nullable|string|max:255',
            'permanent_zip' => 'nullable|string|max:255',
            'permanent_district' => 'nullable|string|max:255',
            'permanent_upazila_id' => 'nullable|exists:upazilas,id',
            'permanent_country' => 'nullable|string|max:255',

            // Emergency Contact
            'guardian_number' => 'nullable|string|max:255',
            'ref_address' => 'nullable|string|max:255',

            // Marital Status & Children
            'marital_status' => 'nullable|string|in:Single,Married,Divorced,Widowed',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_number' => 'nullable|string|max:255',
            'no_of_children' => 'nullable|integer|min:0',

            // Official Information
            'employee_id' => [
                'required', 'string', 'max:255',
                Rule::unique('employees', 'employee_id')->ignore($employee->id),
            ],
            'employee_code' => [
                'nullable', 'string', 'max:255',
                Rule::unique('employees', 'employee_code')->ignore($employee->id),
            ],
            'status' => 'required|string|in:Active,Pending,Inactive,Blocked,Suspended',
            'unit_id' => 'nullable|exists:units,id',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'section_id' => 'nullable|exists:sections,id',
            'division_id' => 'nullable|exists:divisions,id',
            'line_id' => 'nullable|exists:lines,id',
            'join_date' => 'required|date_format:m/d/Y',
            'staff_category_id' => 'nullable|exists:staff_categories,id',
            'salary_grade_id' => 'nullable|exists:salary_grades,id',
            'shift_plan_id' => 'nullable|exists:shift_plans,id',
            'leave_rule_id' => 'nullable|exists:policy_masters,id',
            'attendance_rule' => 'nullable|exists:policy_masters,id',
            'employment_nature' => 'nullable|string|in:Permanent,Temporary,Provision,Contractual',
            'weekend_rule_ids' => 'nullable|array',
            'weekend_rule_ids.*' => 'exists:policy_masters,id',
            'reporting_func_id' => 'nullable|exists:employees,id',
            'reporting_admin_id' => 'nullable|exists:employees,id',

            // Bank Information
            'bank_id' => 'nullable|exists:banks,id',
            'bank_branch_id' => 'nullable|exists:bank_branches,id',
            'account_number' => 'nullable|string|max:255',

            // Entitlements & Self Service
            'ent_overtime' => 'boolean',
            'ent_bonus' => 'boolean',
            'ent_offday_ot' => 'boolean',
            'ent_pf' => 'boolean',
            'provident_fund_date' => 'nullable|date_format:m/d/Y',
            'provident_fund_account_no' => 'nullable|string|max:255',
            'ent_insurance' => 'boolean',
            'insurance_id' => 'nullable|exists:insurances,id',
            'insurance_account' => 'nullable|string|max:255',
            'insurance_type' => 'nullable|string|max:255',
            'insurance_amount' => 'nullable|numeric',
            'consider_service_length' => 'boolean',
            'service_length' => 'nullable|integer|min:0',
            'service_length_unit' => 'nullable|string|in:Month,Year',

            'self_service' => 'boolean',
            // Login Information for User table (nullable for update)
            'username' => [
                Rule::requiredIf($request->boolean('self_service')),
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employee->user->id ?? null), // Unique except for current user's email
            ],
            'password' => 'nullable|string|min:8|confirmed', // Password is nullable: only update if provided
            'password_confirmation' => 'nullable',

            // Educational Information
            'institute_name' => 'nullable|string|max:255',
            'exam_name' => 'nullable|string|max:255',
            'authority_name' => 'nullable|string|max:255',
            'exam_level' => 'nullable|string|max:255',
            'course_duration' => 'nullable|numeric|min:0',
            'exam_year' => 'nullable|integer|digits:4|min:1900|max:' . (date('Y') + 5),
            'major' => 'nullable|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'cgpa' => 'nullable|numeric|between:0,5.00',
            'mark_avail' => 'nullable|string|in:Yes,No',
            'total_mark' => 'nullable|integer|min:0',

            // Employee Experiences
            'company_name' => 'nullable|string|max:255',
            'designation_experience' => 'nullable|string|max:255',
            'country_experience' => 'nullable|string|max:255',
            'city_experience' => 'nullable|string|max:255',
            'address_experience' => 'nullable|string|max:255',
            'start_date_experience' => 'nullable|date_format:m/d/Y',
            'end_date_experience' => 'nullable|date_format:m/d/Y|after_or_equal:start_date_experience',
            'start_salary' => 'nullable|numeric|min:0',
            'end_salary' => 'nullable|numeric|min:0|gte:start_salary',
            'currency' => 'nullable|string|max:255',
            'responsibilities' => 'nullable|string',

            // User Documents
            'file_name' => 'nullable|string|max:255',
            'achievement_date' => 'nullable|date_format:m/d/Y',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,txt,xlsx,csv|max:5120',
            'remove_photo' => 'nullable|boolean', // Hidden input for photo removal
            'remove_current_document' => 'nullable|boolean', // Hidden input for document removal
        ]);

        // Handle photo removal/update
        $validatedData['emp_photo'] = $employee->emp_photo; // Default to existing
        if ($request->has('remove_photo') && $request->input('remove_photo') == '1') {
            if ($employee->emp_photo && Storage::disk('public')->exists('employee_photos/' . $employee->emp_photo)) {
                Storage::disk('public')->delete('employee_photos/' . $employee->emp_photo);
            }
            $validatedData['emp_photo'] = null;
        } elseif ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($employee->emp_photo && Storage::disk('public')->exists('employee_photos/' . $employee->emp_photo)) {
                Storage::disk('public')->delete('employee_photos/' . $employee->emp_photo);
            }
            $validatedData['emp_photo'] = $request->file('photo')->store('employee_photos', 'public');
            $validatedData['emp_photo'] = basename($validatedData['emp_photo']);
        }

        // Handle document removal/update
        $validatedData['file_path'] = $employee->file_path; // Default to existing
        if ($request->has('remove_current_document') && $request->input('remove_current_document') == '1') {
            if ($employee->file_path && Storage::disk('public')->exists('employee_documents/' . $employee->file_path)) {
                Storage::disk('public')->delete('employee_documents/' . $employee->file_path);
            }
            $validatedData['file_name'] = null;
            $validatedData['file_path'] = null;
        } elseif ($request->hasFile('file_path')) {
            // Delete old document if exists
            if ($employee->file_path && Storage::disk('public')->exists('employee_documents/' . $employee->file_path)) {
                Storage::disk('public')->delete('employee_documents/' . $employee->file_path);
            }
            $validatedData['file_path'] = $request->file('file_path')->store('employee_documents', 'public');
            $validatedData['file_path'] = basename($validatedData['file_path']);
        }

        // Date formatting for database storage (YYYY-MM-DD)
        $dateFields = ['dob', 'join_date', 'provident_fund_date', 'start_date_experience', 'end_date_experience', 'achievement_date'];
        foreach ($dateFields as $field) {
            if (isset($validatedData[$field])) {
                $validatedData[$field] = Carbon::createFromFormat('m/d/Y', $validatedData[$field])->format('Y-m-d');
            }
        }

        // Permanent Address logic if "Same as Present Address" is checked
        if ($request->boolean('same_as_present_address')) {
            $validatedData['permanent_address'] = $validatedData['present_address'] ?? null;
            $validatedData['permanent_po'] = $validatedData['present_po'] ?? null;
            $validatedData['permanent_ps'] = $validatedData['present_ps'] ?? null;
            $validatedData['permanent_zip'] = $validatedData['present_zip'] ?? null;
            $validatedData['permanent_district'] = $validatedData['present_district'] ?? null;
            $validatedData['permanent_upazila_id'] = $validatedData['present_upazila_id'] ?? null;
            $validatedData['permanent_country'] = $validatedData['present_country'] ?? null;
        }

        // Weekend rule গুলো JSON encode করে স্টোর করুন
        $validatedData['weekend_rule_id'] = json_encode($validatedData['weekend_rule_ids'] ?? []);

        // যদি নতুন ছবি আপলোড করা হয়
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/employees'), $imageName);
            $validatedData['photo'] = 'uploads/employees/' . $imageName;

            // পুরোনো ছবি থাকলে মুছে দিন
            if ($employee->photo && file_exists(public_path($employee->photo))) {
                unlink(public_path($employee->photo));
            }
        }

        // Employee আপডেট করুন
        $employee->update($validatedData);

        // ইউজার আপডেট (যদি Self Service active থাকে)
        if ($request->boolean('self_service')) {
            $userData = [
                'name' => $employee->full_name, // full_name accessor থেকে
                'email' => $validatedData['username'],
            ];
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($validatedData['password']);
            }

            if ($employee->user) {
                $employee->user->update($userData);
            } else {
                $user = new \App\Models\User($userData);
                $user->save();
                $employee->user_id = $user->id;
                $employee->save();
            }
        }

        return redirect()->route('employees.index')
            ->with('success', 'কর্মচারীর তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Remove the specified resource from storage.
     * স্টোরেজ থেকে নির্দিষ্ট রিসোর্স মুছে ফেলুন।
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        // Delete associated photo and document files from storage
        if ($employee->emp_photo) {
            Storage::disk('public')->delete('employee_photos/' . $employee->emp_photo);
        }
        if ($employee->file_path) {
            Storage::disk('public')->delete('employee_documents/' . $employee->file_path);
        }

        // Delete the associated user account if it exists
        if ($employee->user) {
            $employee->user->delete();
        }

        // Delete the employee record
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
