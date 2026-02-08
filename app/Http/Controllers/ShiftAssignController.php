<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\ShiftPlan;
use App\Models\Unit;
use App\Models\Department;
use App\Models\Division;
use App\Models\Designation;
use App\Models\Section;
use App\Models\Line; // Assuming you have a Line model
use App\Models\ShiftAssignment; // Assuming you have this model for saving assignments

class ShiftAssignController extends Controller
{
    // ... index method if you have one ...

    public function create()
    {
        // Fetch all necessary master data for filters and select boxes
        $units = Unit::all();
        $departments = Department::all();
        $divisions = Division::all();
        $designations = Designation::all();
        $sections = Section::all();
        $lines = Line::all(); // Assuming you have this model
        $shiftPlans = ShiftPlan::where('status', 'active')->get(); // Only active shift plans

        return view('shift_assigns.create', compact(
            'units',
            'departments',
            'divisions',
            'designations',
            'sections',
            'lines',
            'shiftPlans'
        ));
    }

    // This store method will now handle AJAX request from Alpine.js
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'employee_ids' => 'required|array|min:1',
            'employee_ids.*' => 'exists:employees,id',
            'shift_plan_id' => 'required|exists:shift_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Wrap the assignment in a database transaction for atomicity
        \DB::transaction(function () use ($validatedData) {
            foreach ($validatedData['employee_ids'] as $employeeId) {
                ShiftAssignment::create([
                    'employee_id' => $employeeId,
                    'shift_plan_id' => $validatedData['shift_plan_id'],
                    'start_date' => $validatedData['start_date'],
                    'end_date' => $validatedData['end_date'],
                    'remarks' => $validatedData['remarks'],
                    // You might want to add 'assigned_by' (Auth::id()), 'status', etc.
                ]);
            }
        });
        
        // Return a JSON response for AJAX requests
        return response()->json(['message' => 'Shifts assigned successfully!'], 200);
    }
}