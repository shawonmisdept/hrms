<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;

class LeaveApplicationController extends Controller
{
    public function index()
    {
        $leaveApplications = LeaveApplication::with('leaveType')->latest()->paginate(10);
        return view('leave_applications.index', compact('leaveApplications'));
    }

    public function create()
    {
        $employees = class_exists(Employee::class) ? Employee::where('status', 1)->get() : collect();
        $leaveTypes = LeaveType::where('status', 1)->get();
        return view('leave_applications.create', compact('employees', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        LeaveApplication::create($request->all());

        return redirect()->route('leave-applications.index')->with('success', 'Leave application submitted.');
    }

    public function edit(LeaveApplication $leaveApplication)
    {
        $employees = class_exists(Employee::class) ? Employee::where('status', 1)->get() : collect();
        $leaveTypes = LeaveType::where('status', 1)->get();
        return view('leave_applications.edit', compact('leaveApplication', 'leaveTypes', 'employees'));
    }

    public function update(Request $request, LeaveApplication $leaveApplication)
    {
        $request->validate([
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $leaveApplication->update($request->all());

        return redirect()->route('leave-applications.index')->with('success', 'Leave application updated.');
    }

    public function destroy(LeaveApplication $leaveApplication)
    {
        $leaveApplication->delete();
        return redirect()->back()->with('success', 'Leave application deleted.');
    }
}
