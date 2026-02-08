@extends('layouts.dashboard')

@section('content')
<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-700">Division List</h2>
        <a href="{{ route('divisions.create') }}" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">+ Add New</a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Name</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Code</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Description</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Manager Name</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Phone</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Created At</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Created By</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($divisions as $key => $division)
                <tr>
                    <td class="px-4 py-2">{{ $key + 1 }}</td>
                    <td class="px-4 py-2">{{ $division->name }}</td>
                    <td class="px-4 py-2">{{ $division->code }}</td>
                    <td class="px-4 py-2">{{ $division->description }}</td>
                    <td class="px-4 py-2">{{ $division->manager_name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $division->manager_email }}</td>
                    <td class="px-4 py-2">{{ $division->manager_phone }}</td>
                    <td class="px-4 py-2">{{ $division->created_at->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">{{ optional($division->creator)->name }}</td>
                    <td class="px-4 py-2">
                        @if($division->status == 'active')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Active</span>
                        @elseif($division->status == 'inactive')
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Inactive</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Blocked</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('divisions.edit', $division->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('divisions.destroy', $division->id) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($divisions->count() == 0)
                <tr>
                    <td colspan="11" class="text-center text-gray-500 py-4">No data available.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
