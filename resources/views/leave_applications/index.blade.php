@extends('layouts.dashboard')

@section('title', 'Leave Applications')

@section('content')
<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Leave Applications</h1>
        <a href="{{ route('leave-applications.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add New</a>
    </div>

    @if (session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium">#</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Leave Type</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Start Date</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">End Date</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($leaveApplications as $index => $leave)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $leave->leaveType->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $leave->start_date }}</td>
                        <td class="px-4 py-2">{{ $leave->end_date }}</td>
                        <td class="px-4 py-2">
                            <span class="text-xs px-2 py-1 rounded-full {{
                                $leave->status === 'approved' ? 'bg-green-100 text-green-600' :
                                ($leave->status === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600')
                            }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 space-x-1">
                            <a href="{{ route('leave-applications.edit', $leave->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('leave-applications.destroy', $leave->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $leaveApplications->links() }}
    </div>
</div>
@endsection