@extends('layouts.dashboard')
@section('content')
<div class="p-6 max-w-9xl mx-auto">

    <h1 class="text-2xl font-semibold text-gray-700 mb-5">Section</h1>

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

        <a href="{{ route('sections.create') }}"
           class="bg-green-600 text-white px-2 py-1 rounded text-sm hover:bg-green-700">
            + Create Section
        </a>
    </div>

    <table class="min-w-full border border-gray-300 rounded overflow-hidden text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 border-b border-gray-300">#</th>
                <th class="px-4 py-2 border-b border-gray-300">Name</th>
                <th class="px-4 py-2 border-b border-gray-300">Description</th>
                <th class="px-4 py-2 border-b border-gray-300">Manager Name</th>
                <th class="px-4 py-2 border-b border-gray-300">Manager Email</th>
                <th class="px-4 py-2 border-b border-gray-300">Phone</th>
                <th class="px-4 py-2 border-b border-gray-300">Created By</th>
                <th class="px-4 py-2 border-b border-gray-300">Status</th>
                <th class="px-4 py-2 border-b border-gray-300 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sections as $index => $section)
                <tr class="odd:bg-white even:bg-gray-50">
                    <td class="px-4 py-2 border-b border-gray-300">{{ $sections->firstItem() + $index }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $section->name }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $section->description }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">
                        {{ optional($section->manager)->name ?? $section->manager_id }}
                    </td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $section->manager_email }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $section->manager_phone }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ optional($section->creator)->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $section->status }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 text-center space-x-2">

                        <a href="{{ route('sections.edit', $section->id) }}"
                           class="text-blue-600 hover:underline">Edit</a>

                        <form action="{{ route('sections.destroy', $section->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure to delete this section?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center p-4 text-gray-500">No sections found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $sections->links() }}
    </div>
</div>
@endsection
