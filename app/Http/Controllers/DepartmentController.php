<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_head_id' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'status' => 'required|in:0,1',
        ]);

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'department_head_id' => $request->department_head_id,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully!');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_head_id' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'status' => 'required|in:0,1',
        ]);

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'department_head_id' => $request->department_head_id,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully!');
    }

    public function toggleStatus(Department $department)
    {
        $department->status = !$department->status;
        $department->save();

        return redirect()->route('departments.index')->with('success', 'Status changed successfully!');
    }
    public function show($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department);
    }
}
