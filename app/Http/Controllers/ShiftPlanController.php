<?php

namespace App\Http\Controllers;

use App\Models\ShiftPlan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShiftPlanController extends Controller
{
    public function index()
    {
        $shiftPlans = ShiftPlan::latest()->paginate(10);
        return view('shift_plans.index', compact('shiftPlans'));
    }

    public function create()
    {
        return view('shift_plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Convert time to H:i:s
        $start = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i:s');
        $end = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i:s');

        // Calculate total work hours
        $startTime = Carbon::createFromFormat('H:i:s', $start);
        $endTime = Carbon::createFromFormat('H:i:s', $end);
        if ($endTime->lessThan($startTime)) {
            $endTime->addDay(); // Handle overnight shifts
        }
        $totalHours = $startTime->diffInMinutes($endTime) / 60;

        ShiftPlan::create([
            'name' => $request->name,
            'start_time' => $start,
            'end_time' => $end,
            'description' => $request->description,
            'status' => $request->status,
            'total_hours' => $totalHours,
        ]);

        return redirect()->route('shift_plans.index')->with('success', 'Shift plan created successfully.');
    }

    public function edit(ShiftPlan $shiftPlan)
    {
        return view('shift_plans.edit', compact('shiftPlan'));
    }

    public function update(Request $request, ShiftPlan $shiftPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Convert time to H:i:s
        $start = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i:s');
        $end = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i:s');

        // Calculate total work hours
        $startTime = Carbon::createFromFormat('H:i:s', $start);
        $endTime = Carbon::createFromFormat('H:i:s', $end);
        if ($endTime->lessThan($startTime)) {
            $endTime->addDay(); // Handle overnight shifts
        }
        $totalHours = $startTime->diffInMinutes($endTime) / 60;

        $shiftPlan->update([
            'name' => $request->name,
            'start_time' => $start,
            'end_time' => $end,
            'description' => $request->description,
            'status' => $request->status,
            'total_hours' => $totalHours,
        ]);

        return redirect()->route('shift_plans.index')->with('success', 'Shift plan updated successfully.');
    }

    public function destroy(ShiftPlan $shiftPlan)
    {
        $shiftPlan->delete();
        return redirect()->route('shift_plans.index')->with('success', 'Shift plan deleted successfully.');
    }

    public function toggleStatus(ShiftPlan $shiftPlan)
    {
        $shiftPlan->status = $shiftPlan->status === 'active' ? 'inactive' : 'active';
        $shiftPlan->save();

        return redirect()->route('shift_plans.index')->with('success', 'Shift plan status updated.');
    }
}
