<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LineController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $lines = Line::with('manager', 'creator')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('manager_email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('lines.index', compact('lines'));
    }

    public function create()
    {
        $employees = Employee::select('id', 'employee_code', 'first_name', 'middle_name', 'last_name')->get();
        return view('lines.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'required|string|max:100|unique:lines,code',
            'description'    => 'nullable|string',
            'manager_id'     => 'nullable|exists:employees,id',
            'manager_email'  => 'nullable|email',
            'manager_phone'  => 'nullable|string|max:20',
            'status'         => 'required|in:active,inactive',
        ]);

        Line::create([
            'name'           => $request->name,
            'code'           => $request->code,
            'description'    => $request->description,
            'manager_id'     => $request->manager_id,
            'manager_email'  => $request->manager_email,
            'manager_phone'  => $request->manager_phone,
            'status'         => $request->status,
            'created_by'     => Auth::id(),
        ]);

        return redirect()->route('lines.index')->with('success', 'Line created successfully.');
    }

    public function edit($id)
    {
        $line = Line::findOrFail($id);
        $employees = Employee::select('id', 'employee_code', 'first_name', 'middle_name', 'last_name')->get();
        return view('lines.edit', compact('line', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $line = Line::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => "required|string|max:100|unique:lines,code,{$line->id}",
            'description'    => 'nullable|string',
            'manager_id'     => 'nullable|exists:employees,id',
            'manager_email'  => 'nullable|email',
            'manager_phone'  => 'nullable|string|max:20',
            'status'         => 'required|in:active,inactive',
        ]);

        $line->update([
            'name'           => $request->name,
            'code'           => $request->code,
            'description'    => $request->description,
            'manager_id'     => $request->manager_id,
            'manager_email'  => $request->manager_email,
            'manager_phone'  => $request->manager_phone,
            'status'         => $request->status,
        ]);

        return redirect()->route('lines.index')->with('success', 'Line updated successfully.');
    }

    public function destroy($id)
    {
        $line = Line::findOrFail($id);
        $line->delete();

        return redirect()->route('lines.index')->with('success', 'Line deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $line = Line::findOrFail($id);
        $line->status = $line->status === 'active' ? 'inactive' : 'active';
        $line->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
