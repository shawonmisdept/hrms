<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Unit;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    // Display the list of education records with search functionality
    public function index(Request $request)
    {
        $search = $request->input('search');

        $educations = Education::with('unit')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('native_name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('educations.index', compact('educations', 'search'));
    }

    // Show the form to create a new education record
    public function create()
    {
        // Get only active units
        $units = Unit::where('status', 1)->get();
        return view('educations.create', compact('units'));
    }

    // Store a newly created education record in storage
    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'native_name' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        Education::create($request->only(['unit_id', 'name', 'native_name', 'status'])); // Explicitly defining the fields to be stored

        return redirect()->route('education.index')->with('success', 'Education created successfully.'); // Updated route name
    }

    // Show the form to edit an existing education record
    public function edit(Education $education)
    {
        $units = Unit::all();
        return view('educations.edit', compact('education', 'units'));
    }

    // Update an existing education record in storage
    public function update(Request $request, Education $education)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'native_name' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        // Update only specific fields to prevent unwanted changes
        $education->update($request->only(['unit_id', 'name', 'native_name', 'status'])); 

        return redirect()->route('education.index')->with('success', 'Education updated successfully.'); // Updated route name
    }

    // Remove the specified education record from storage
    public function destroy(Education $education)
    {
        $education->delete();
        return redirect()->route('education.index')->with('success', 'Education deleted.');
    }
    public function toggleStatus(Education $education)
{
    // Toggle the status between active and inactive
    $education->status = !$education->status;
    $education->save();

    return redirect()->route('education.index')->with('success', 'Status updated successfully.');
}

}
