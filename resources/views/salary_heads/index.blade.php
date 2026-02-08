@extends('layouts.Dashboard')

@section('content')
    <div class="max-w-8xl mx-auto bg-white p-4 rounded shadow text-sm">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Salary Heads</h2>
            <a href="{{ route('salary_heads.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Add New</a>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('salary_heads.index') }}" class="mb-4 flex items-center justify-between">
            <div class="flex items-center space-x-2 w-full">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="border px-3 py-1 rounded w-1/3 text-sm"
                    placeholder="Search by name...">
                <button type="submit" class="bg-gray-700 text-white px-3 py-1 rounded text-sm">Search</button>
            </div>
        </form>

        <table class="w-full border text-sm table-auto">
            <thead class="bg-gray-100 text-xs">
                <tr>
                    <th class="border px-2 py-2 text-left w-8">#</th>
                    <th class="border px-2 py-2 text-left w-32">Head Name</th>
                    <th class="border px-2 py-2 text-left w-48">Description</th>
                    <th class="border px-2 py-2 text-left w-24">Head Type</th>
                    <th class="border px-2 py-2 text-left w-24">Perquisite</th>
                    <th class="border px-2 py-2 text-left w-24">Disburse</th>
                    <th class="border px-2 py-2 text-left w-20">Sequence</th>
                    <th class="border px-2 py-2 text-left w-20">Sort Code</th>
                    <th class="border px-2 py-2 w-28">Created At</th>
                    <th class="border px-2 py-2 text-left w-20">Status</th>
                    <th class="border px-2 py-2 w-px whitespace-nowrap text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($salaryHeads as $key => $head)
                    <tr class="hover:bg-gray-50 text-xs">
                        <td class="border px-2 py-1">{{ $salaryHeads->firstItem() + $key }}</td>
                        <td class="border px-2 py-1 truncate">{{ $head->name }}</td>
                        <td class="border px-2 py-1 truncate">{{ $head->description }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $head->head_type }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $head->perquisite }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $head->disburse }}</td>
                        <td class="border px-2 py-1">{{ $head->sequence }}</td>
                        <td class="border px-2 py-1">{{ $head->sort_code }}</td>
                        <td class="border px-2 py-1">{{ $head->created_at->format('d M Y') }}</td>
                        <td class="border px-2 py-1">
                            <span class="flex justify-center items-center px-1 py-1 text-xs rounded font-semibold 
                                {{ $head->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $head->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="border px-2 py-1 text-center">
                            <div class="flex justify-center items-center space-x-1">
                                {{-- Toggle Status --}}
                                <form method="POST" action="{{ route('salary_heads.toggle', $head->id) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="text-white text-xs px-2 py-0.5 rounded {{ $head->status ? 'bg-blue-500 hover:bg-blue-600' : 'bg-green-500 hover:bg-green-600' }}">
                                        {{ $head->status ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                {{-- Edit --}}
                                <a href="{{ route('salary_heads.edit', $head->id) }}"
                                    class="text-white text-xs px-2 py-0.5 bg-yellow-500 hover:bg-yellow-600 rounded">
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('salary_heads.destroy', $head->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-white text-xs px-2 py-0.5 bg-red-600 hover:bg-red-700 rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr> 
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-2">No salary heads found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $salaryHeads->withQueryString()->links() }}
        </div>
    </div>
@endsection
