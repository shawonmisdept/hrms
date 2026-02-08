@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create User</h2>

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Full Name -->
        <div class="mb-4">
            <label for="full_name" class="block text-gray-700 font-medium mb-2">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('full_name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mobile -->
        <div class="mb-4">
            <label for="mobile" class="block text-gray-700 font-medium mb-2">Mobile</label>
            <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            @error('mobile')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Role -->
        <div class="mb-4">
            <label for="role_id" class="block text-gray-700 font-medium mb-2">Role</label>
            <select name="role_id" id="role_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
            <input type="password" id="password" name="password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Profile Image -->
        <div class="mb-4">
            <label for="profile_image" class="block text-gray-700 font-medium mb-2">Profile Image</label>
            <input type="file" id="profile_image" name="profile_image"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            @error('profile_image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Create User
            </button>
        </div>
    </form>
</div>
@endsection
