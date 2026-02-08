<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, ProfileController, DepartmentController, EmployeeController,
    DesignationController, ShiftPlanController, WeekendController, UnitController,
    StaffCategoryController, CountryController, DistrictController, UpazilaController,
    BankController, BankBranchController, EducationController, SalaryHeadController,
    SalaryGradeController, SalaryGradeDetailController, LeaveTypeController,
    LeaveApplicationController, OvertimeSlabController, PolicyMasterController,
    PolicyDetailController, BonusAssignController, UserController,
    Auth\LoginController, ShiftAssignController, SectionController,
    LineController, DivisionController, InsuranceController
};

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// ✅ Protected Routes
Route::middleware(['auth'])->group(function () {

    // ✅ Now dashboard route is protected
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard-data', [DashboardController::class, 'getDashboardData']);

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Departments
    Route::resource('departments', DepartmentController::class);
    Route::patch('departments/{department}/toggle-status', [DepartmentController::class, 'toggleStatus'])->name('departments.toggleStatus');

    // Designations
    Route::resource('designations', DesignationController::class);
    Route::patch('designations/{id}/toggle-status', [DesignationController::class, 'toggleStatus'])->name('designations.toggleStatus');

    // Employees
    Route::resource('employees', EmployeeController::class)->middleware([
        'permission:view employee|create employee|edit employee|delete employee'
    ]);
    Route::patch('employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggleStatus');
    Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

    // Shift Plans
    Route::resource('shift_plans', ShiftPlanController::class);
    Route::patch('shift_plans/{shift_plan}/toggle-status', [ShiftPlanController::class, 'toggleStatus'])->name('shift_plans.toggleStatus');

    // Weekends
    Route::resource('weekends', WeekendController::class);
    Route::patch('weekends/{weekend}/toggle-status', [WeekendController::class, 'toggleStatus'])->name('weekends.toggleStatus');

    // Units
    Route::resource('units', UnitController::class);
    Route::patch('units/{unit}/toggle-status', [UnitController::class, 'toggleStatus'])->name('units.toggleStatus');

    // Staff Categories
    Route::resource('staff_categories', StaffCategoryController::class);
    Route::get('staff_categories/{staffCategory}/toggle-status', [StaffCategoryController::class, 'toggleStatus'])->name('staff_categories.toggleStatus');

    // Countries
    Route::resource('countries', CountryController::class);
    Route::patch('countries/{country}/toggle-status', [CountryController::class, 'toggleStatus'])->name('countries.toggleStatus');

    // Districts
    Route::resource('districts', DistrictController::class);
    Route::patch('districts/{district}/toggle-status', [DistrictController::class, 'toggleStatus'])->name('districts.toggleStatus');

    // Upazilas
    Route::resource('upazilas', UpazilaController::class);
    Route::patch('upazilas/{upazila}/toggle-status', [UpazilaController::class, 'toggleStatus'])->name('upazilas.toggleStatus');

    // Banks
    Route::resource('banks', BankController::class);
    Route::patch('banks/{bank}/toggle-status', [BankController::class, 'toggleStatus'])->name('banks.toggleStatus');

    // Bank Branches
    Route::resource('bank_branches', BankBranchController::class);
    Route::patch('bank_branches/{bankBranch}/toggle-status', [BankBranchController::class, 'toggleStatus'])->name('bank_branches.toggleStatus');

    // Education
    Route::prefix('education')->name('education.')->group(function () {
        Route::get('/', [EducationController::class, 'index'])->name('index');
        Route::get('/create', [EducationController::class, 'create'])->name('create');
        Route::post('/', [EducationController::class, 'store'])->name('store');
        Route::get('/{education}/edit', [EducationController::class, 'edit'])->name('edit');
        Route::patch('/{education}', [EducationController::class, 'update'])->name('update');
        Route::delete('/{education}', [EducationController::class, 'destroy'])->name('destroy');
        Route::patch('/{education}/toggleStatus', [EducationController::class, 'toggleStatus'])->name('toggleStatus');
    });

    // Salary Head
    Route::resource('salary_heads', SalaryHeadController::class);
    Route::patch('salary_heads/{id}/toggle', [SalaryHeadController::class, 'toggle'])->name('salary_heads.toggle');

    // Salary Grade Details
    Route::resource('salary-grade-details', SalaryGradeDetailController::class);
    Route::get('salary-grade-details-toggle/{id}', [SalaryGradeDetailController::class, 'toggleStatus'])->name('salary-grade-details.toggle');

    // Salary Grades
    Route::resource('salary-grades', SalaryGradeController::class);
    Route::patch('salary-grades/{id}/toggle', [SalaryGradeController::class, 'toggleStatus'])->name('salary-grades.toggle');
    Route::get('salary-grades/{id}/modal-view', [SalaryGradeController::class, 'modalView'])->name('salary-grades.modal-view');

    // Leave Types
    Route::resource('leave-types', LeaveTypeController::class);
    Route::patch('leave-types/{id}/toggle', [LeaveTypeController::class, 'toggle'])->name('leave-types.toggle');

    // Leave Applications
    Route::resource('leave-applications', LeaveApplicationController::class);

    // Overtime Slabs
    Route::resource('overtime-slabs', OvertimeSlabController::class);

    // Policy Master & Details
    Route::resource('policy-masters', PolicyMasterController::class);
    Route::resource('policy-details', PolicyDetailController::class);

    // Bonus Assign
    Route::prefix('bonus-assigns')->name('bonus-assigns.')->group(function () {
        Route::get('/', [BonusAssignController::class, 'index'])->name('index');
        Route::get('/create', [BonusAssignController::class, 'create'])->name('create');
        Route::post('/store', [BonusAssignController::class, 'store'])->name('store');
        Route::get('/assigned-policies/{employee}', [BonusAssignController::class, 'getAssignedPolicies'])->name('assigned-policies');
    });

    // Users
    Route::middleware('permission:view_users')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });
    Route::resource('users', UserController::class)->except(['index']);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/settings', [UserController::class, 'settings'])->name('settings');

    // Shift Assignment
    Route::get('/shift-assign', [ShiftAssignController::class, 'index'])->name('shift_assigns.index');
    Route::get('/shift-assign/create', [ShiftAssignController::class, 'create'])->name('shift_assigns.create');
    Route::post('/shift-assign', [ShiftAssignController::class, 'store'])->name('shift_assigns.store');

    // Section
    Route::resource('sections', SectionController::class);

    // Line
    Route::resource('lines', LineController::class);
    Route::patch('lines/{line}/toggle-status', [LineController::class, 'toggleStatus'])->name('lines.toggleStatus');

    // Division
    Route::resource('divisions', DivisionController::class);

    // Insurance
    Route::resource('insurances', InsuranceController::class);
});

require __DIR__.'/auth.php';
