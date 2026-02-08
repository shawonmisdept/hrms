<?php

namespace App\Http\Controllers;

use App\Models\OvertimeSlab;
use App\Models\Employee;
use Illuminate\Http\Request;

class OvertimeSlabController extends Controller
{
    public function index()
    {
        $slabs = OvertimeSlab::latest()->paginate(10);
        return view('overtime-slabs.index', compact('slabs'));
    }

    public function create()
    {
        $employees = Employee::where('status', 1)->get();
        return view('overtime-slabs.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'employee_ids' => 'array|nullable',
        ]);

        $slab = OvertimeSlab::create($request->only('name', 'rate', 'description', 'status'));
        if ($request->employee_ids) {
            $slab->employees()->attach($request->employee_ids);
        }

        return redirect()->route('overtime-slabs.index')->with('success', 'Overtime slab created.');
    }

    public function edit(OvertimeSlab $overtimeSlab)
    {
        $employees = Employee::where('status', 1)->get();
        $selectedEmployees = $overtimeSlab->employees->pluck('id')->toArray();

        return view('overtime_slabs.edit', compact('overtimeSlab', 'employees', 'selectedEmployees'));
    }

    public function update(Request $request, OvertimeSlab $overtimeSlab)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        $overtimeSlab->update($request->only('name', 'rate', 'description', 'status'));
        $overtimeSlab->employees()->sync($request->employee_ids ?? []);

        return redirect()->route('overtime-slabs.index')->with('success', 'Overtime slab updated.');
    }

    public function destroy(OvertimeSlab $overtimeSlab)
    {
        $overtimeSlab->employees()->detach();
        $overtimeSlab->delete();
        return back()->with('success', 'Overtime slab deleted.');
    }
}
