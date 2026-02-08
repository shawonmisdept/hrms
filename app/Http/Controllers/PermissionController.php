<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\Module;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::with('module')->get();
        $modules = Module::all();

        $editItem = $request->has('edit') ? Permission::findOrFail($request->edit) : null;

        return view('permissions.index', compact('permissions', 'modules', 'editItem'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'module' => 'required',
        ]);

        Permission::create([
            'name' => $request->name,
            'module' => $request->module,
        ]);

        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
