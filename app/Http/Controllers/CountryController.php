<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->paginate(10);
        return view('countries.index', compact('countries'));
    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'native_name' => 'nullable|string',
            'code' => 'nullable|string|max:10',
            'phone_code' => 'nullable|string|max:10',
            'currency_code' => 'nullable|string|max:10',
            'status' => 'required|in:0,1',
        ]);

        Country::create($request->all());

        return redirect()->route('countries.index')->with('success', 'Country created successfully!');
    }

    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'native_name' => 'nullable|string',
            'code' => 'nullable|string|max:10',
            'phone_code' => 'nullable|string|max:10',
            'currency_code' => 'nullable|string|max:10',
            'status' => 'required|in:0,1',
        ]);

        $country->update($request->all());

        return redirect()->route('countries.index')->with('success', 'Country updated successfully!');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully!');
    }

    public function toggleStatus(Country $country)
    {
        $country->status = !$country->status;
        $country->save();
        return redirect()->route('countries.index')->with('success', 'Status changed successfully!');
    }
}
