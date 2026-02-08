@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-9xl mx-auto">

    <h1 class="text-2xl font-semibold text-gray-700 mb-5">Units</h1>

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

        <a href="{{ route('units.create') }}"
           class="bg-green-600 text-white px-2 py-1 rounded text-sm hover:bg-green-700">
            + Create Unit
        </a>
    </div>

    <table class="min-w-full border border-gray-300 rounded overflow-hidden text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 border-b border-gray-300">#</th>
                <th class="px-4 py-2 border-b border-gray-300">Name</th>
                <th class="px-4 py-2 border-b border-gray-300">Address</th>
                <th class="px-4 py-2 border-b border-gray-300">Email</th>
                <th class="px-4 py-2 border-b border-gray-300">Phone</th>
                <th class="px-4 py-2 border-b border-gray-300">Status</th>
                <th class="px-4 py-2 border-b border-gray-300">Created At</th>
                <th class="px-4 py-2 border-b border-gray-300 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($units as $index => $unit)
                <tr class="odd:bg-white even:bg-gray-50">
                    <td class="px-4 py-2 border-b border-gray-300">{{ $units->firstItem() + $index }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $unit->name }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $unit->address ?? '-' }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $unit->email ?? '-' }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $unit->phone ?? '-' }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 capitalize">{{ $unit->status }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $unit->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 text-center space-x-2">

                        <a href="{{ route('units.edit', $unit->id) }}"
                           class="text-blue-600 hover:underline">Edit</a>

                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure to delete this unit?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center p-4 text-gray-500">No units found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $units->links() }}
    </div>
</div>
@endsection
