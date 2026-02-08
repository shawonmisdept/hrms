<?php

namespace App\Http\Controllers;

use App\Models\StaffCategory;
use Illuminate\Http\Request;

class StaffCategoryController extends Controller
{
    public function index()
    {
        $staffCategories = StaffCategory::latest()->paginate(10);
        return view('staff_categories.index', compact('staffCategories'));
    }

    public function create()
    {
        return view('staff_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        StaffCategory::create($request->all());
        return redirect()->route('staff_categories.index')->with('success', 'Staff Category created successfully!');
    }

    public function edit(StaffCategory $staffCategory)
    {
        return view('staff_categories.edit', compact('staffCategory'));
    }

    public function update(Request $request, StaffCategory $staffCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $staffCategory->update($request->all());
        return redirect()->route('staff_categories.index')->with('success', 'Staff Category updated successfully!');
    }

    public function destroy(StaffCategory $staffCategory)
    {
        $staffCategory->delete();
        return redirect()->route('staff_categories.index')->with('success', 'Staff Category deleted successfully!');
    }

    public function toggleStatus(StaffCategory $staffCategory)
    {
        $staffCategory->status = !$staffCategory->status;
        $staffCategory->save();
        return redirect()->route('staff_categories.index')->with('success', 'Status changed successfully!');
    }
    
}
