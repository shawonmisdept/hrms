<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'user_type' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $user = new User();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->role_id = $request->role_id;
        $user->user_type = $request->user_type;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profiles', $filename);
            $user->profile_image = $filename;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'user_type' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->role_id = $request->role_id;
        $user->user_type = $request->user_type;
        $user->status = $request->status;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::exists('public/profiles/' . $user->profile_image)) {
                Storage::delete('public/profiles/' . $user->profile_image);
            }

            $file = $request->file('profile_image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profiles', $filename);
            $user->profile_image = $filename;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function destroy(User $user)
    {
        // Delete image from storage
        if ($user->profile_image && Storage::exists('public/profiles/' . $user->profile_image)) {
            Storage::delete('public/profiles/' . $user->profile_image);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public function profile()
{
    return view('profile'); // resources/views/profile.blade.php
}
}
