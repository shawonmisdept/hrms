<?php

namespace App\Http\Controllers;

use App\Models\SalaryHead;
use Illuminate\Http\Request;

class SalaryHeadController extends Controller
{
    Public function index(Request $request)
    {
        $query = SalaryHead::query();
    
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        $salaryHeads = $query->orderBy('sequence')->paginate(10);
        return view('salary_heads.index', compact('salaryHeads'));
    }




    public function create()
    {
        return view('salary_heads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'head_type' => 'required',
            'sequence' => 'required|integer',
            'perquisite' => 'required|in:yes,no',
            'disburse' => 'required|in:yes,no',
        ]);

        SalaryHead::create($request->all());

        return redirect()->route('salary_heads.index')->with('success', 'Salary head created successfully.');
    }

    public function edit(SalaryHead $salaryHead)
    {
        return view('salary_heads.create', compact('salaryHead'));
    }

    public function update(Request $request, SalaryHead $salaryHead)
    {
        $request->validate([
            'name' => 'required',
            'head_type' => 'required',
            'sequence' => 'required|integer',
            'perquisite' => 'required|in:yes,no',
            'disburse' => 'required|in:yes,no',
        ]);

        $salaryHead->update($request->all());

        return redirect()->route('salary_heads.index')->with('success', 'Salary head updated successfully.');
    }

    public function destroy(SalaryHead $salaryHead)
    {
        $salaryHead->delete();

        return redirect()->route('salary_heads.index')->with('success', 'Salary head deleted successfully.');
    }

    public function toggleStatus(SalaryHead $salaryHead)
    {
        $salaryHead->status = !$salaryHead->status;
        $salaryHead->save();

        return redirect()->route('salary_heads.index')->with('success', 'Status updated successfully.');
    }
    public function toggle($id)
    {
        $head = SalaryHead::findOrFail($id);
        $head->status = !$head->status;
        $head->save();

        return redirect()->back()->with('success', 'Status updated.');
    }
    
}
