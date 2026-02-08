@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold text-gray-700">Overtime Slabs</h1>
            <a href="{{ route('overtime-slabs.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-4 py-2 rounded shadow">
                ➕ Create New
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border text-left">Name</th>
                        <th class="px-4 py-2 border text-left">Rate (৳)</th>
                        <th class="px-4 py-2 border text-left">Assigned Employees</th>
                        <th class="px-4 py-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                     @forelse ($slabs as $index => $slab)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $slab->name }}</td>
                            <td class="px-4 py-2 border">৳ {{ number_format($slab->rate, 2) }}</td>
                            <td class="px-4 py-2 border">
                                {{ $slab->employees->pluck('name')->join(', ') }}
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('overtime-slabs.edit', $slab->id) }}"
                                   class="text-blue-500 hover:underline text-sm mr-2">Edit</a>
                                <form action="{{ route('overtime-slabs.destroy', $slab->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="text-red-500 hover:underline text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No Overtime Slabs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
