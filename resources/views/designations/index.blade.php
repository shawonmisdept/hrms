@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-9xl mx-auto">

    <h1 class="text-2xl font-semibold text-gray-700 mb-5">Designations</h1>

    <div class="flex justify-between items-center mb-5">
        <form method="GET" class="flex space-x-2">
            <input type="text" name="search" placeholder="Search..."
                   value="{{ request('search') }}"
                   class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="submit"
                    class="bg-blue-600 text-white px-2 py-1 rounded text-sm hover:bg-blue-700">
                Search
            </button>
        </form>

        <a href="{{ route('designations.create') }}"
           class="bg-green-600 text-white px-2 py-1 rounded text-sm hover:bg-green-700">
            + Create 
        </a>
    </div>

    <table class="min-w-full border border-gray-300 rounded overflow-hidden text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 border-b border-gray-300">#</th>
                <th class="px-4 py-2 border-b border-gray-300">Name</th>
                <th class="px-4 py-2 border-b border-gray-300">Description</th>
                <th class="px-4 py-2 border-b border-gray-300 text-center">Employees</th>
                <th class="px-4 py-2 border-b border-gray-300 text-center">Status</th>
                <th class="px-4 py-2 border-b border-gray-300">Created</th>
                <th class="px-4 py-2 border-b border-gray-300">Updated</th>
                <th class="px-4 py-2 border-b border-gray-300 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($designations as $index => $designation)
                <tr class="odd:bg-white even:bg-gray-50">
                    <td class="px-4 py-2 border-b border-gray-300">{{ $designations->firstItem() + $index }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $designation->name }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $designation->description ?? '-' }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 text-center">{{ $designation->employees_count ?? 0 }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 text-center capitalize">
                        @if($designation->status === 'active')
                            <span class="text-green-600 text-xs font-medium bg-green-100 px-2 py-1 rounded-full">Active</span>
                        @else
                            <span class="text-red-600 text-xs font-medium bg-red-100 px-2 py-1 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $designation->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $designation->updated_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 text-center space-x-2">
                        <a href="{{ route('designations.edit', $designation->id) }}"
                           class="text-blue-600 hover:underline">Edit</a>
                          
                        <form action="{{ route('designations.destroy', $designation->id) }}"
                              method="POST" class="inline-block"
                              onsubmit="return confirm('Are you sure to delete this designation?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center p-4 text-gray-500">No designations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $designations->links() }}
    </div>

</div>
@endsection
