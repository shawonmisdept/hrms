<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upazila;
use App\Models\District;

class UpazilaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $upazilas = Upazila::with('district')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('upazilas.index', compact('upazilas', 'search'));
    }

    public function create()
    {
        $districts = District::where('status', 1)->get();
        return view('upazilas.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'status' => 'nullable|boolean',
        ]);

        Upazila::create([
            'name' => $request->name,
            'district_id' => $request->district_id,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('upazilas.index')->with('success', 'Upazila created successfully.');
    }

    public function edit(Upazila $upazila)
    {
        $districts = District::where('status', 1)->get();
        return view('upazilas.edit', compact('upazila', 'districts'));
    }

    public function update(Request $request, Upazila $upazila)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'status' => 'nullable|boolean',
        ]);

        $upazila->update([
            'name' => $request->name,
            'district_id' => $request->district_id,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('upazilas.index')->with('success', 'Upazila updated successfully.');
    }

    public function destroy(Upazila $upazila)
    {
        $upazila->delete();
        return back()->with('success', 'Upazila deleted successfully.');
    }

    public function toggleStatus(Upazila $upazila)
    {
        $upazila->status = !$upazila->status;
        $upazila->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
