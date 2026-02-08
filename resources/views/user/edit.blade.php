@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-semibold mb-6">Edit User</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Full Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block mb-1">Mobile</label>
                <input type="text" name="mobile" value="{{ $user->mobile }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-1">Role</label>
                <select name="role_id" class="w-full border rounded p-2" required>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">User Type</label>
                <input type="text" name="user_type" value="{{ $user->user_type }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border rounded p-2" required>
                    <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block mb-1">Password (leave blank if not changing)</label>
                <input type="password" name="password" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <div class="col-span-2">
                <label class="block mb-1">Profile Image</label>
                <input type="file" name="image" class="w-full border rounded p-2">
                @if($user->image)
                    <img src="{{ asset('storage/'.$user->image) }}" class="mt-2 w-24 h-24 rounded-full object-cover">
                @endif
            </div>
        </div>

        <div class="mt-6 text-right">
            <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
        </div>
    </form>
</div>
@endsection
