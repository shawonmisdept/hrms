<?php

namespace App\Http\Controllers;

use App\Models\BonusAssign;
use App\Models\Employee;
use App\Models\PolicyMaster;
use Illuminate\Http\Request;

class BonusAssignController extends Controller
{
    public function index(Request $request)
    {
        // Handle search
        $search = $request->input('search');
        $employees = Employee::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                         ->orWhere('employee_code', 'like', "%$search%");
        })->paginate(10);

        // Get selected employee for assigned policy display
        $selectedEmployeeId = $request->input('selected_employee_id');
        
        // Initialize assignedPolicies as an empty collection if no employee is selected
        $assignedPolicies = collect();

        if ($selectedEmployeeId) {
            // Fetch assigned policies for the selected employee
            $assignedPolicies = BonusAssign::with(['employee', 'policyMaster'])
                ->where('employee_id', $selectedEmployeeId)
                ->paginate(10);
        }

        // Return the view with all necessary data
        return view('bonus_assigns.index', compact('employees', 'assignedPolicies', 'selectedEmployeeId', 'search'));
    }

    public function create()
    {
        // Fetch employees and policies for creating a new bonus assignment
        $employees = Employee::paginate(10);
        $policies = PolicyMaster::paginate(10);
        return view('bonus_assigns.create', compact('employees', 'policies'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'employee_ids' => 'required|array',
            'policy_id' => 'required|exists:policy_masters,id',
        ]);

        // Create or update bonus assignment records for each employee
        foreach ($request->employee_ids as $employeeId) {
            BonusAssign::updateOrCreate([
                'employee_id' => $employeeId,
                'policy_master_id' => $request->policy_id,
            ]);
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'Bonus assigned successfully!');
    }

    public function getAssignedPolicies(Employee $employee)
    {
        // Fetch all assigned policies for the given employee
        $assignedPolicies = $employee->bonusAssignments()->with('policyMaster')->get();

        // Return partial view for assigned policies
        return view('bonus_assign.partials.assigned_policies', compact('assignedPolicies'));
    }
}
