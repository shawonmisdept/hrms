@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-9xl mx-auto">

    <h1 class="text-2xl font-semibold text-gray-700 mb-5">Staff Categories</h1>

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

        <a href="{{ route('staff_categories.create') }}"
           class="bg-green-600 text-white px-2 py-1 rounded text-sm hover:bg-green-700">
            + Add New
        </a>
    </div>

    <table class="min-w-full border border-gray-300 rounded overflow-hidden text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 border-b border-gray-300">#</th>
                <th class="px-4 py-2 border-b border-gray-300">Name</th>
                <th class="px-4 py-2 border-b border-gray-300">Description</th>
                <th class="px-4 py-2 border-b border-gray-300">Status</th>
                <th class="px-4 py-2 border-b border-gray-300">Created At</th>
                <th class="px-4 py-2 border-b border-gray-300">Updated At</th>
                <th class="px-4 py-2 border-b border-gray-300 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($staffCategories as $index => $category)
                <tr class="odd:bg-white even:bg-gray-50">
                    <td class="px-4 py-2 border-b border-gray-300">{{ $staffCategories->firstItem() + $index }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $category->name }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $category->description ?? '-' }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">
                        @if($category->status)
                            <span class="text-green-600 font-semibold">Active</span>
                        @else
                            <span class="text-red-600 font-semibold">Inactive</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $category->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $category->updated_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 text-center space-x-2">

                        <a href="{{ route('staff_categories.edit', $category->id) }}"
                           class="text-blue-600 hover:underline">Edit</a>

                        <form action="{{ route('staff_categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure to delete this staff category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center p-4 text-gray-500">No staff categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $staffCategories->links() }}
    </div>
</div>
@endsection
