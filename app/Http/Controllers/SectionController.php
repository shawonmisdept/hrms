<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with(['manager', 'creator'])->latest()->paginate(10);
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        $employees = Employee::select('id', 'employee_code', 'first_name', 'middle_name', 'last_name')->get();
        return view('sections.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'manager_id' => 'required',
        ]);

        Section::create([
            'name' => $request->name,
            'description' => $request->description,
            'manager_id' => $request->manager_id ?: null,
            'manager_email' => $request->manager_email,
            'manager_phone' => $request->manager_phone,
            'status' => $request->status ?? 'Active',
            'created_by' => Auth::id()
        ]);

        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }
}
