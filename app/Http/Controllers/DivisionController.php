<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $query = Division::with(['manager', 'creator']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('code', 'like', "%$search%");
        }

        $divisions = $query->latest()->paginate(10);

        return view('divisions.index', compact('divisions'));
    }

    public function create()
    {
        $employees = Employee::select('id', 'employee_code', 'first_name', 'middle_name', 'last_name')->get();
        return view('divisions.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|integer|exists:employees,id',
            'manager_email' => 'nullable|email',
            'manager_phone' => 'nullable|string',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $manager_name = null;
        if ($validated['manager_id']) {
            $manager = Employee::find($validated['manager_id']);
            if ($manager) {
                $manager_name = $manager->name;
            }
        }

        Division::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'description' => $validated['description'],
            'manager_id' => $validated['manager_id'],
            'manager_name' => $manager_name,
            'manager_email' => $validated['manager_email'],
            'manager_phone' => $validated['manager_phone'],
            'status' => $validated['status'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('divisions.index')->with('success', 'Division created successfully');
    }

    public function edit(Division $division)
    {
        $employees = Employee::select('id', 'employee_code', 'first_name', 'middle_name', 'last_name')->get();
        return view('divisions.edit', compact('division', 'employees'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:employees,employee_code',
            'manager_email' => 'nullable|email',
            'manager_phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $division->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'manager_id' => $request->manager_id,
            'manager_email' => $request->manager_email,
            'manager_phone' => $request->manager_phone,
            'status' => $request->status,
        ]);

        return redirect()->route('divisions.index')->with('success', 'Division updated successfully.');
    }

    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully.');
    }
}
