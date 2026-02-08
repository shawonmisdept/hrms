<?php

namespace App\Http\Controllers;

use App\Models\SalaryGrade;
use Illuminate\Http\Request;

class SalaryGradeController extends Controller
{
    public function index(Request $request)
    {
        $query = SalaryGrade::query();

        if ($request->filled('search')) {
            $query->where('grade_name', 'like', '%' . $request->search . '%');
        }

        $salaryGrades = SalaryGrade::with(['createdByUser', 'details.head', 'details.parentHead'])->paginate(10);
        return view('salary_grades.index', compact('salaryGrades'));
        
    }

    public function create()
    {
        return view('salary_grades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        SalaryGrade::create([
            'grade_name' => $request->grade_name,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('salary-grades.index')->with('success', 'Salary grade created successfully.');
    }

    public function edit(SalaryGrade $salaryGrade)
    {
        return view('salary_grades.create', compact('salaryGrade'));
    }

    public function update(Request $request, SalaryGrade $salaryGrade)
    {
        $request->validate([
            'grade_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $salaryGrade->update([
            'grade_name' => $request->grade_name,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('salary-grades.index')->with('success', 'Salary grade updated successfully.');
    }

    public function destroy(SalaryGrade $salaryGrade)
    {
        $salaryGrade->delete();

        return redirect()->route('salary-grades.index')->with('success', 'Salary grade deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $grade = SalaryGrade::findOrFail($id);
        $grade->status = !$grade->status;
        $grade->save();

        return redirect()->back()->with('success', 'Status updated.');
    }
}
