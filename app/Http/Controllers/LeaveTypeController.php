<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::latest()->paginate(10);
        return view('leave-types.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('leave-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_days' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        LeaveType::create([
            'name' => $request->name,
            'description' => $request->description,
            'max_days' => $request->max_days,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('leave-types.index')->with('success', 'Leave type created successfully.');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_days' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $leaveType->update([
            'name' => $request->name,
            'description' => $request->description,
            'max_days' => $request->max_days,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('leave-types.index')->with('success', 'Leave type updated successfully.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();
        return redirect()->route('leave-types.index')->with('success', 'Leave type deleted successfully.');
    }

    public function toggle($id)
    {
        $leaveType = LeaveType::findOrFail($id);
        $leaveType->status = !$leaveType->status;
        $leaveType->save();

        return redirect()->back()->with('success', 'Leave Type status updated successfully.');
    }
}
