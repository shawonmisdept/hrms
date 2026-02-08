<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Country;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $query = District::with('country');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $districts = $query->latest()->paginate(10);
        return view('districts.index', compact('districts'));
    }

    public function create()
    {
        $countries = Country::where('status', 1)->get(); // Note: status is integer
        return view('districts.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'status' => 'required|in:active,inactive',
        ]);

        District::create($request->only('name', 'country_id', 'status'));

        return redirect()->route('districts.index')->with('success', 'District created successfully.');
    }

    public function edit(District $district)
    {
        $countries = Country::where('status', 1)->get();
        return view('districts.edit', compact('district', 'countries'));
    }

    public function update(Request $request, District $district)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'status' => 'required|in:active,inactive',
        ]);

        $district->update($request->only('name', 'country_id', 'status'));

        return redirect()->route('districts.index')->with('success', 'District updated successfully.');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return back()->with('success', 'District deleted.');
    }

    public function toggleStatus($id)
    {
        $district = District::findOrFail($id);
        $district->status = $district->status === 'active' ? 'inactive' : 'active';
        $district->save();

        return back()->with('success', 'Status updated.');
    }
}
