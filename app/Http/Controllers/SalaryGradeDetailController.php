<?php

namespace App\Http\Controllers;

use App\Models\SalaryGrade;
use App\Models\SalaryGradeDetail;
use App\Models\SalaryHead;
use Illuminate\Http\Request;

class SalaryGradeDetailController extends Controller
{
    // Display a listing of Salary Grade Details.
    public function index(Request $request)
    {
        // Retrieve all salary grades
        $grades = SalaryGrade::all();

        // Get selected grade from the request
        $selectedGrade = $request->grade_id;
        
        // Get salary grade details with relations (grade, head, parentHead)
        $details = SalaryGradeDetail::with(['grade', 'head', 'parentHead'])
            ->when($selectedGrade, function ($query) use ($selectedGrade) {
                return $query->where('grade_id', $selectedGrade);
            })
            ->orderBy('id', 'desc')
            ->get();

        // Pass data to view
        return view('salary_grade_details.index', compact('details', 'grades', 'selectedGrade'));
    }

    // Show the form to create a new Salary Grade Detail
    public function create()
    {
        // Get all salary grades and salary heads
        $grades = SalaryGrade::all();
        $heads = SalaryHead::orderBy('sequence')->get();

        // Return the create view
        return view('salary_grade_details.create', compact('grades', 'heads'));
    }

    // Store a newly created Salary Grade Detail
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'grade_id' => 'required|exists:salary_grades,id',
            'head_id' => 'required|exists:salary_heads,id',
            'fixed' => 'required|boolean',
            'type' => 'nullable|in:F,M,%', // Fixed, Formula, Percentage
            'formula' => 'nullable|string',
            'parent_head_id' => 'nullable|exists:salary_heads,id',
            'parent_head_value' => 'nullable|numeric',
            'is_higher' => 'required|boolean',
        ]);

        // Create new SalaryGradeDetail record
        SalaryGradeDetail::create($request->all());

        // Redirect back to the index with success message
        return redirect()->route('salary-grade-details.index')
            ->with('success', 'Salary Grade Detail created successfully.');
    }

    // Show the form to edit an existing Salary Grade Detail
    public function edit(SalaryGradeDetail $salary_grade_detail)
    {
        // Get all salary grades and salary heads
        $grades = SalaryGrade::all();
        $heads = SalaryHead::orderBy('sequence')->get();

        // Return the edit view with the existing salary grade detail
        return view('salary_grade_details.edit', [
            'detail' => $salary_grade_detail, 
            'grades' => $grades,
            'heads' => $heads
        ]);
    }

    // Update an existing Salary Grade Detail
    public function update(Request $request, SalaryGradeDetail $salary_grade_detail)
    {
        // Validate incoming request
        $request->validate([
            'grade_id' => 'required|exists:salary_grades,id',
            'head_id' => 'required|exists:salary_heads,id',
            'fixed' => 'required|boolean',
            'type' => 'nullable|in:F,M,%',
            'formula' => 'nullable|string',
            'parent_head_id' => 'nullable|exists:salary_heads,id',
            'parent_head_value' => 'nullable|numeric',
            'is_higher' => 'required|boolean',
        ]);

        // Update the SalaryGradeDetail record
        $salary_grade_detail->update($request->all());

        // Redirect back to the index with success message
        return redirect()->route('salary-grade-details.index')
            ->with('success', 'Salary Grade Detail updated successfully.');
    }

    // Delete a Salary Grade Detail
    public function destroy(SalaryGradeDetail $salaryGradeDetail)
    {
        // Delete the record
        $salaryGradeDetail->delete();

        // Redirect back with success message
        return redirect()->back()
            ->with('success', 'Salary Grade Detail deleted successfully.');
    }
    public function show($id)
{
    // Fetch the SalaryGrade along with the related details and createdBy
    $grade = SalaryGrade::with([
        'details.head:id,name', // Fetching related head information
        'details.parentHead:id,name', // Fetching related parent head
    ])->findOrFail($id);

    // Return the data as JSON for AJAX
    return response()->json([
        'grade' => [
            'id' => $grade->id,
            'grade_name' => $grade->grade_name,
            'status' => $grade->status ? 'Active' : 'Inactive',
            'created_by' => $grade->createdBy->name ?? 'N/A',
            'created_at' => $grade->created_at->format('d M Y'),
            'updated_at' => $grade->updated_at->format('d M Y'),
        ],
        'details' => $grade->details->map(function ($detail) {
            return [
                'grade' => $detail->grade->grade_name ?? '-',
                'head' => $detail->head->name ?? '-',
                'fixed' => $detail->fixed ? 'Yes' : 'No',
                'type' => $detail->type ?? '-',
                'parent_head' => $detail->parentHead->name ?? '-',
                'value_or_formula' => $detail->type === 'M' ? $detail->formula : ($detail->parent_head_value ?? '-'),
                'is_higher' => $detail->is_higher ? 'Yes' : 'No',
                'created_at' => $detail->created_at->format('d M Y'),
            ];
        }),
    ]);
}
}
