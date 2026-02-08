<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insurances = Insurance::latest()->paginate(10);
        return view('insurances.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('insurances.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'coverage_amount' => 'nullable|numeric',
        'premium' => 'nullable|numeric',
        'provider_name' => 'nullable|string|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'status' => 'required|boolean',
    ]);

    Insurance::create([
        'name' => $request->name,
        'description' => $request->description,
        'coverage_amount' => $request->coverage_amount,
        'premium' => $request->premium,
        'provider_name' => $request->provider_name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'status' => $request->status,
        'created_by' => auth()->id(),
    ]);

        return redirect()->route('insurances.index')->with('success', 'Insurance created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Insurance $insurance)
    {
        return view('insurances.show', compact('insurance'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $insurance)
    {
        return view('insurances.edit', compact('insurance'));
    }

    public function update(Request $request, Insurance $insurance)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coverage_amount' => 'nullable|numeric',
            'premium' => 'nullable|numeric',
            'provider_name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        $insurance->update([
            'name' => $request->name,
            'description' => $request->description,
            'coverage_amount' => $request->coverage_amount,
            'premium' => $request->premium,
            'provider_name' => $request->provider_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

    return redirect()->route('insurances.index')->with('success', 'Insurance updated successfully.');
    }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Insurance $insurance)
    {
        $insurance->delete();

        return redirect()->route('insurances.index')->with('success', 'Insurance deleted successfully.');
    }
}
