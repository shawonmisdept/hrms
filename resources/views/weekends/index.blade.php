@extends('layouts.dashboard')

@section('content')
    <div class="p-6">

        <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4">
        <h1 class="text-3xl font-semibold text-gray-700 mb-6">Weekends</h1>    
        <div class="flex justify-end mb-2">
                <a href="{{ route('weekends.create') }}"
                   class="inline-block bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded">
                    Add New
                </a>
            </div>

            <table class="min-w-full border border-gray-300 text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-3 text-xs font-bold uppercase">#</th>
                        <th class="border px-4 py-3 text-xs font-bold uppercase">Name</th>
                        <th class="border px-4 py-3 text-xs font-bold uppercase">Description</th>
                        <th class="border px-4 py-3 text-xs font-bold uppercase">Status</th>
                        <th class="border px-4 py-3 text-xs font-bold uppercase">Created At</th>
                        <th class="border px-4 py-3 text-xs font-bold uppercase">Updated At</th>
                        <th class="border px-2 py-3 text-xs font-bold uppercase w-48">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weekends as $weekend)
                        <tr class="hover:bg-gray-50 text-xs">
                            <td class="border px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-3">{{ $weekend->name }}</td>
                            <td class="border px-4 py-3">{{ $weekend->description ?? '-' }}</td>
                            <td class="border px-4 py-3">
                                @if($weekend->status === 'active')
                                    <span class="text-green-600 font-bold">Active</span>
                                @else
                                    <span class="text-red-600 font-bold">Inactive</span>
                                @endif
                            </td>
                            <td class="border px-4 py-3">{{ $weekend->created_at->format('Y-m-d') }}</td>
                            <td class="border px-4 py-3">{{ $weekend->updated_at->format('Y-m-d') }}</td>
                            <td class="border px-2 py-2">
                            <div class="flex flex-row flex-wrap justify-center gap-1">
                            {{-- ✏️ Edit --}}
                            <a href="{{ route('weekends.edit', $weekend->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white p-1 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536M9 11l6-6M5 19h14M5 19l4-4 4 4 4-4 4 4"/>
                                </svg>
                            </a>

                            {{-- 🔄 Toggle Status --}}
                            <form action="{{ route('weekends.toggleStatus', $weekend->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure to change status?');" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v16h16V4H4z"/>
                                    </svg>
                                </button>
                            </form>

                            {{-- 🗑️ Delete --}}
                            <form action="{{ route('weekends.destroy', $weekend->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure to delete?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">{{ $weekends->links() }}</div>
        </div>
    </div>
@endsection
