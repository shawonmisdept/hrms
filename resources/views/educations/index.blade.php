@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4">
        <h1 class="text-3xl font-semibold text-gray-700 mb-6">Education</h1>

        <div class="flex justify-between items-center mb-4">
            {{-- ➕ Add New --}}
            <a href="{{ route('education.create') }}" class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded">
                ➕ Add New
            </a>

            {{-- 🔍 Search --}}
            <form method="GET" action="{{ route('education.index') }}" class="flex items-center gap-2">
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
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Unit</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Name</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Native Name</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Status</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Created At</th>
                    <th class="border px-2 py-3 text-xs font-bold uppercase w-48">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($educations as $education)
                    <tr class="hover:bg-gray-50 text-xs">
                        <td class="border px-4 py-3">{{ $loop->iteration + ($educations->currentPage() - 1) * $educations->perPage() }}</td>
                        <td class="border px-4 py-3">{{ $education->unit?->name ?? '—' }}</td>
                        <td class="border px-4 py-3">{{ $education->name }}</td>
                        <td class="border px-4 py-3">{{ $education->native_name }}</td>
                        <td class="border px-4 py-3">
                            @if($education->status == 1)
                                <span class="text-green-600 font-bold">Active</span>
                            @else
                                <span class="text-red-600 font-bold">Inactive</span>
                            @endif
                        </td>
                        <td class="border px-4 py-3">{{ $education->created_at->format('Y-m-d') }}</td>
                        <td class="border px-2 py-2">
                            <div class="flex flex-row flex-wrap justify-center gap-1">
                                {{-- ✏️ Edit --}}
                                <a href="{{ route('education.edit', $education->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white p-1 rounded">
                                    ✏️
                                </a>

                                {{-- 🔄 Toggle Status --}}
                                <form action="{{ route('education.toggleStatus', $education->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure to change status?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white p-1 rounded">
                                        🔄
                                    </button>
                                </form>

                                {{-- 🗑️ Delete --}}
                                <form action="{{ route('education.destroy', $education->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure to delete?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white p-1 rounded">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-sm py-4 text-gray-500">No education entries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $educations->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
