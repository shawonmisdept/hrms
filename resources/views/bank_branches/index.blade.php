@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4">
        <h1 class="text-3xl font-semibold text-gray-700 mb-6">Bank Branches</h1>

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('bank_branches.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded">
                ➕ Add New
            </a>

            <form method="GET" action="{{ route('bank_branches.index') }}" class="flex items-center gap-2">
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
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Branch Name</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Status</th>
                    <th class="border px-4 py-3 text-xs font-bold uppercase">Created At</th>
                    <th class="border px-2 py-3 text-xs font-bold uppercase w-48">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bankBranches as $bankBranch)
                    <tr class="hover:bg-gray-50 text-xs">
                        <td class="border px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-3">{{ $bankBranch->bank->name }}</td>
                        <td class="border px-4 py-3">{{ $bankBranch->name }}</td>
                        <td class="border px-4 py-3">
                            @if($bankBranch->status)
                                <span class="text-green-600 font-bold">Active</span>
                            @else
                                <span class="text-red-600 font-bold">Inactive</span>
                            @endif
                        </td>
                        <td class="border px-4 py-3">{{ $bankBranch->created_at->format('Y-m-d') }}</td>
                        <td class="border px-2 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('bank_branches.edit', $bankBranch->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white p-1 rounded">
                                    ✏️ 
                                </a>
                                <form action="{{ route('bank_branches.toggleStatus', $bankBranch->id) }}" method="POST" onsubmit="return confirm('Are you sure to change status?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-yellow-500 text-white p-1 rounded">
                                        🔄 
                                    </button>
                                </form>
                                <form action="{{ route('bank_branches.destroy', $bankBranch->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-1 rounded">
                                        🗑️ 
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $bankBranches->links() }}</div>
    </div>
</div>
@endsection
