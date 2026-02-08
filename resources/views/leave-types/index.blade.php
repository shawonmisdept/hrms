@extends('layouts.Dashboard')

@section('content')
    <div class="max-w-8xl mx-auto bg-white p-4 rounded shadow text-sm">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Leave Types</h2>
            <a href="{{ route('leave-types.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Add New</a>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('leave-types.index') }}" class="mb-4 flex items-center justify-between">
            <div class="flex items-center space-x-2 w-full">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="border px-3 py-1 rounded w-1/3 text-sm"
                    placeholder="Search by name...">
                <button type="submit" class="bg-gray-700 text-white px-3 py-1 rounded text-sm">Search</button>
            </div>
        </form>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr class="py-2">
                    <th class="border px-2 py-3 text-left w-10">#</th>
                    <th class="border px-3 py-3 text-left">Name</th>
                    <th class="border px-3 py-3 text-left">Description</th>
                    <th class="border px-3 py-3 text-left">Max Days</th>
                    <th class="border px-3 py-3 text-left">Created At</th>
                    <th class="border px-3 py-3 text-left">Status</th>
                    <th class="border px-3 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($leaveTypes as $key => $type)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-2 py-1">{{ $leaveTypes->firstItem() + $key }}</td>
                        <td class="border px-3 py-1">{{ $type->name }}</td>
                        <td class="border px-3 py-1">{{ $type->description }}</td>
                        <td class="border px-3 py-1">{{ $type->max_days }}</td>
                        <td class="border px-3 py-1">{{ $type->created_at->format('d M Y') }}</td>
                        <td class="border px-2 py-2">
                            <span class="justify-center items-center px-1 py-1 text-xs rounded font-semibold 
                                {{ $type->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $type->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="border px-2 py-1">
                            <div class="flex justify-center items-center space-x-1">

                                {{-- Toggle --}}
                                <form method="POST" action="{{ route('leave-types.toggle', $type->id) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="p-1 rounded {{ $type->status ? 'bg-blue-500 hover:bg-blue-600' : 'bg-green-500 hover:bg-green-600' }} text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 12l3-3m-3 3-3-3m-12 3l3 3m-3-3-3 3" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- Edit --}}
                                <a href="{{ route('leave-types.edit', $type->id) }}"
                                    class="p-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5m-5.586-9.414a2 2 0 112.828 2.828L11 13l-4 1 1-4 7.414-7.414z" />
                                    </svg>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('leave-types.destroy', $type->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-1 bg-red-600 hover:bg-red-700 text-white rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-2">No leave types found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $leaveTypes->withQueryString()->links() }}
        </div>
    </div>
@endsection
