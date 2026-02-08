@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4">
        <h1 class="text-3xl font-semibold text-gray-700 mb-6">Banks</h1>

        <div class="flex justify-between items-center mb-4">
            {{-- Add New --}}
            <a href="{{ route('banks.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded">
                ➕ Add New
            </a>

            {{-- Search --}}
            <form method="GET" action="{{ route('banks.index') }}" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                       class="border border-gray-300 rounded px-2 py-1 text-xs w-48">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded">
                    🔍 Search
                </button>
            </form>
        </div>

        <table class="min-w-full border border-gray-300 text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">#</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Bank Name</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Short Name</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Status</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Created At</th>
                    <th class="border px-2 py-3 text-xs font-bold uppercase w-48">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                    <tr class="hover:bg-gray-50 text-xs">
                        <td class="border px-4 py-3">{{ $loop->iteration + ($banks->currentPage() - 1) * $banks->perPage() }}</td>
                        <td class="border px-4 py-3">{{ $bank->name }}</td>
                        <td class="border px-4 py-3">{{ $bank->short_name }}</td>
                        <td class="border px-4 py-3">
                            @if($bank->status)
                                <span class="text-green-600 font-bold">Active</span>
                            @else
                                <span class="text-red-600 font-bold">Inactive</span>
                            @endif
                        </td>
                        <td class="border px-4 py-3">{{ $bank->created_at->format('Y-m-d') }}</td>
                        <td class="border px-2 py-2">
                            <div class="flex flex-row flex-wrap justify-center gap-1">
                                {{-- ✏️ Edit --}}
                                <a href="{{ route('banks.edit', $bank->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15.232 5.232l3.536 3.536M9 11l6-6M5 19h14M5 19l4-4 4 4 4-4 4 4"/>
                                    </svg>
                                </a>

                                {{-- 🔄 Toggle Status --}}
                                <form action="{{ route('banks.toggleStatus', $bank->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure to change status?');">
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
                                <form action="{{ route('banks.destroy', $bank->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure to delete?');">
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
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-sm py-4 text-gray-500">No banks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $banks->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
