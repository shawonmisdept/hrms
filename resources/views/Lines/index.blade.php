@extends('layouts.dashboard')


@section('content')
<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Line List</h1>
        <a href="{{ route('lines.create') }}" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">+ Add Line</a>
    </div>

    <div class="mb-4">
        <form method="GET" action="{{ route('lines.index') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                class="border px-2 py-1 rounded w-64">
            <button type="submit" class="bg-gray-600 text-white px-2 py-1 rounded">Search</button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Code</th>
                    <th class="px-4 py-2 border">Description</th>
                    <th class="px-4 py-2 border">Manager Name</th>
                    <th class="px-4 py-2 border">Manager Email</th>
                    <th class="px-4 py-2 border">Phone</th>
                    <th class="px-4 py-2 border">Created At</th>
                    <th class="px-4 py-2 border">Created By</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lines as $key => $line)
                    <tr>
                        <td class="px-4 py-2 border">{{ $lines->firstItem() + $key }}</td>
                        <td class="px-4 py-2 border">{{ $line->name }}</td>
                        <td class="px-4 py-2 border">{{ $line->code }}</td>
                        <td class="px-4 py-2 border">{{ $line->description }}</td>
                        <td class="px-4 py-2 border">{{ $line->manager?->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $line->manager_email }}</td>
                        <td class="px-4 py-2 border">{{ $line->manager_phone }}</td>
                        <td class="px-4 py-2 border">{{ $line->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2 border">{{ $line->creator?->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">
                            <form method="POST" action="{{ route('lines.toggleStatus', $line->id) }}">
                                @csrf
                                @method('PATCH')
                                <button class="text-xs px-2 py-1 rounded 
                                    {{ $line->status === 'active' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ ucfirst($line->status) }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-2 border space-x-1">
                            <a href="{{ route('lines.edit', $line->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('lines.destroy', $line->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-4 py-3 text-center text-gray-500">No lines found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $lines->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
