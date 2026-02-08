<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        $query = Designation::latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // pagination 10 designations per page
        $designations = $query->paginate(10);

        return view('designations.index', compact('designations'));
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Designation::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active', // Default Active
        ]);

        return redirect()->route('designations.index')->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        return view('designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive', // status validate করলাম
        ]);

        $designation->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status, // enum value directly save করলাম
        ]);

        return redirect()->route('designations.index')->with('success', 'Designation updated successfully!');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
    }

    public function toggleStatus(Designation $designation)
    {
        $designation->status = $designation->status === 'active' ? 'inactive' : 'active';
        $designation->save();

        return redirect()->route('designations.index')->with('success', 'Status changed successfully!');
    }
}
