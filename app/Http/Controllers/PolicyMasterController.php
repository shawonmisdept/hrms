<?php

namespace App\Http\Controllers;

use App\Models\PolicyMaster;
use Illuminate\Http\Request;

class PolicyMasterController extends Controller
{
    public function index()
    {
        // ✅ updated to match 'details' relation
        $policyMasters = PolicyMaster::with(['details.salaryHead'])->latest()->paginate(10);
        return view('policy_masters.index', compact('policyMasters'));
    }

    public function create()
    {
        return view('policy_masters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avail_from' => 'required|in:date_of_join,date_of_confirmation',
            'effective_date' => 'required|date',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        PolicyMaster::create($request->all());

        return redirect()->route('policy-masters.index')->with('success', 'Policy created successfully.');
    }

    public function edit(PolicyMaster $policyMaster)
    {
        return view('policy_masters.edit', compact('policyMaster'));
    }

    public function update(Request $request, $id)
    {
        $policyMaster = PolicyMaster::findOrFail($id);

        $policyMaster->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'avail_from' => $request->input('avail_from'),
            'effective_date' => $request->input('effective_date'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('policy-masters.index')->with('success', 'Policy updated successfully');
    }

    public function destroy(PolicyMaster $policyMaster)
    {
        $policyMaster->delete();
        return back()->with('success', 'Policy deleted.');
    }

    public function show(PolicyMaster $policyMaster)
    {
        // ✅ updated to match 'details' relation
        $policyDetails = $policyMaster->details;

        return view('policy_masters.show', compact('policyMaster', 'policyDetails'));
    }
}
