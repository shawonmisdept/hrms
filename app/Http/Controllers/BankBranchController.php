<?php

namespace App\Http\Controllers;

use App\Models\BankBranch;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankBranchController extends Controller
{
    // Index page with optional search
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bankBranches = BankBranch::with('bank')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('bank_branches.index', compact('bankBranches'));
    }

    // Create form
    public function create()
    {
        $banks = Bank::where('status', 1)->get(); // show only active banks
        return view('bank_branches.create', compact('banks'));
    }

    // Store new bank branch
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bank_id' => 'required|exists:banks,id',
            'status' => 'required|boolean',
        ]);

        BankBranch::create([
            'name' => $request->name,
            'bank_id' => $request->bank_id,
            'status' => $request->status,
        ]);

        return redirect()->route('bank_branches.index')->with('success', 'Bank Branch created successfully.');
    }

    // Edit form
    public function edit(BankBranch $bankBranch)
    {
        $banks = Bank::where('status', 1)->get();
        return view('bank_branches.edit', compact('bankBranch', 'banks'));
    }

    // Update existing bank branch
    public function update(Request $request, BankBranch $bankBranch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bank_id' => 'required|exists:banks,id',
            'status' => 'required|boolean',
        ]);

        $bankBranch->update([
            'name' => $request->name,
            'bank_id' => $request->bank_id,
            'status' => $request->status,
        ]);

        return redirect()->route('bank_branches.index')->with('success', 'Bank Branch updated successfully.');
    }

    // Delete bank branch
    public function destroy(BankBranch $bankBranch)
    {
        $bankBranch->delete();

        return redirect()->route('bank_branches.index')->with('success', 'Bank Branch deleted successfully.');
    }

    // Toggle status
    public function toggleStatus(BankBranch $bankBranch)
    {
        $bankBranch->status = !$bankBranch->status;
        $bankBranch->save();

        return redirect()->route('bank_branches.index')->with('success', 'Bank Branch status updated.');
    }
}
