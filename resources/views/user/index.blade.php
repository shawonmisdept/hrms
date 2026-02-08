@extends('layouts.dashboard')


@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">User List</h2>

    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-700 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('users.create') }}"
           class="inline-block px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow">
            + Create User
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 bg-white shadow-sm rounded">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">#</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">Mobile</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">Role</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">Image</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">Created At</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 border-b">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->mobile }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->role->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/profiles/' . $user->profile_image) }}" alt="Profile" class="w-10 h-10 rounded-full">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($user->status === 'active')
                                <span class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-red-200 text-red-800 rounded">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-800">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:underline mr-2">Edit</a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($users->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center px-4 py-6 text-gray-500">No users found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
