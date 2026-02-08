<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $banks = Bank::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('short_name', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('banks.index', compact('banks', 'search'));
    }

    public function create()
    {
        return view('banks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:100',
            'status' => 'nullable|boolean',
        ]);

        Bank::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('banks.index')->with('success', 'Bank created successfully.');
    }

    public function edit(Bank $bank)
    {
        return view('banks.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:100',
            'status' => 'nullable|boolean',
        ]);

        $bank->update([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('banks.index')->with('success', 'Bank updated successfully.');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return back()->with('success', 'Bank deleted successfully.');
    }

    public function toggleStatus(Bank $bank)
    {
        $bank->status = !$bank->status;
        $bank->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
    public function branches()
    {
        return $this->hasMany(BankBranch::class);
    }
}
