<?php

namespace App\Http\Controllers;

use App\Models\PolicyDetail;
use App\Models\PolicyMaster;
use App\Models\SalaryHead;
use Illuminate\Http\Request;

class PolicyDetailController extends Controller
{
    // Show all Policy Details
    public function index()
    {
        $policyDetails = PolicyDetail::with(['policyMaster', 'salaryHead'])
            ->latest()
            ->get();

        return view('policy_details.index', compact('policyDetails'));
    }

    // Show create form
    public function create()
    {
        $policyMasters = PolicyMaster::all();
        $salaryHeads = SalaryHead::all();

        return view('policy_details.create', compact('policyMasters', 'salaryHeads'));
    }

    // Store new policy detail
    public function store(Request $request)
    {
        $validated = $request->validate([
            'policy_master_id'     => 'required|exists:policy_masters,id',
            'salary_head_id'       => 'required|exists:salary_heads,id',
            'type'                 => 'required|in:Fixed,Formula,Percentage',
            'amount'               => 'required|numeric',
            'min_service_length'   => 'required|integer',
            'max_service_length'   => 'required|integer',
            'status'               => 'required|in:active,inactive,blocked',
        ]);

        PolicyDetail::create($validated);

        return redirect()->route('policy-details.index')
            ->with('success', 'Policy Detail created successfully.');
    }

    // Show edit form
    public function edit(PolicyDetail $policyDetail)
    {
        $policyMasters = PolicyMaster::all();
        $salaryHeads = SalaryHead::all();

        return view('policy_details.edit', compact('policyDetail', 'policyMasters', 'salaryHeads'));
    }

    // Update policy detail
    public function update(Request $request, PolicyDetail $policyDetail)
    {
        $validated = $request->validate([
            'policy_master_id'     => 'required|exists:policy_masters,id',
            'salary_head_id'       => 'required|exists:salary_heads,id',
            'type'                 => 'required|in:Fixed,Formula,Percentage',
            'amount'               => 'required|numeric',
            'min_service_length'   => 'required|integer',
            'max_service_length'   => 'required|integer',
            'status'               => 'required|in:active,inactive,blocked',
        ]);

        $policyDetail->update($validated);

        return redirect()->route('policy-details.index')
            ->with('success', 'Policy Detail updated successfully.');
    }

    // Redirect show() to index to avoid error
    public function show(PolicyDetail $policyDetail)
    {
        return redirect()->route('policy-details.index');
    }

    // Delete policy detail
    public function destroy(PolicyDetail $policyDetail)
    {
        $policyDetail->delete();

        return redirect()->route('policy-details.index')
            ->with('success', 'Policy Detail deleted successfully.');
    }
}
