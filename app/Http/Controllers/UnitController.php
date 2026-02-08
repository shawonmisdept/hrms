<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->paginate(10);
        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        Unit::create($validated);

        return redirect()->route('units.index')->with('success', 'Unit created successfully.');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $unit->update($validated);

        return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }

    public function toggleStatus(Unit $unit)
    {
        $unit->status = $unit->status === 'active' ? 'inactive' : 'active';
        $unit->save();

        return redirect()->route('units.index')->with('success', 'Status changed successfully.');
    }
}
