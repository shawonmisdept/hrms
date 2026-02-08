<?php

namespace App\Http\Controllers;

use App\Models\Weekend;
use Illuminate\Http\Request;

class WeekendController extends Controller
{
    public function index()
    {
        $weekends = Weekend::latest()->paginate(10);
        return view('weekends.index', compact('weekends'));
    }

    public function create()
    {
        return view('weekends.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Weekend::create($request->all());

        return redirect()->route('weekends.index')->with('success', 'Weekend created successfully.');
    }

    public function edit(Weekend $weekend)
    {
        return view('weekends.edit', compact('weekend'));
    }

    public function update(Request $request, Weekend $weekend)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $weekend->update($request->all());

        return redirect()->route('weekends.index')->with('success', 'Weekend updated successfully.');
    }

    public function destroy(Weekend $weekend)
    {
        $weekend->delete();
        return redirect()->route('weekends.index')->with('success', 'Weekend deleted successfully.');
    }

    public function toggleStatus(Weekend $weekend)
    {
        $weekend->update([
            'status' => $weekend->status === 'active' ? 'inactive' : 'active',
        ]);
        return redirect()->route('weekends.index')->with('success', 'Status updated.');
    }
}