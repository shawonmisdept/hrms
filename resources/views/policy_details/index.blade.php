@extends('layouts.dashboard')

@section('content')
<div class="max-w-8xl mx-auto mt-8 bg-white p-6 rounded shadow text-xs">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-base font-bold">Bonus Policy Detail List</h2>
        <a href="{{ route('policy-details.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded text-xs">+ Create</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-xs">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100 text-xs font-semibold">
                <tr>
                    <th class="border px-3 py-2 text-left">#</th>
                    <th class="border px-3 py-2 text-left">Policy Master</th>
                    <th class="border px-3 py-2 text-left">Salary Head</th>
                    <th class="border px-3 py-2 text-left">Type</th>
                    <th class="border px-3 py-2 text-left">Amount / %</th>
                    <th class="border px-3 py-2 text-left">Min Service Length</th>
                    <th class="border px-3 py-2 text-left">Max Service Length</th>
                    <th class="border px-3 py-2 text-left">Created</th>
                    <th class="border px-3 py-2 text-left">Status</th>
                    <th class="border px-3 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($policyDetails as $index => $detail)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-2 py-1">{{ $index + 1 }}</td>
                        <td class="border px-2 py-1">{{ $detail->policyMaster->name ?? '-' }}</td>
                        <td class="border px-2 py-1">{{ $detail->salaryHead->name ?? '-' }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $detail->type }}</td>
                        <td class="border px-2 py-1">{{ $detail->amount ?? '-' }}</td>
                        <td class="border px-2 py-1">{{ $detail->min_service_length }}</td>
                        <td class="border px-2 py-1">{{ $detail->max_service_length }}</td>
                        <td class="border px-2 py-1">{{ $detail->created_at->format('d-m-Y') }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $detail->status }}</td>
                        <td class="border px-2 py-1 space-x-2">
                            <a href="{{ route('policy-details.edit', $detail->id) }}" class="text-blue-500 hover:underline text-xs">Edit</a>
                            <form action="{{ route('policy-details.destroy', $detail->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-xs" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-gray-500">No Policy Details available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
