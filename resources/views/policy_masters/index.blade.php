@extends('layouts.dashboard') 

@section('content')
<div class="max-w-8xl mx-auto mt-8 bg-white p-6 rounded shadow text-xs">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-base font-bold">Policy Master List</h2>
        <a href="{{ route('policy-masters.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded text-xs">+ Create</a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-xs">
        {{ session('success') }}
    </div>
    @endif

    <!-- Table Wrapper -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100 text-xs font-semibold">
                <tr>
                    <th class="border px-3 py-2 text-left">#</th>
                    <th class="border px-3 py-2 text-left">Policy Master</th>
                    <th class="border px-3 py-2 text-left">Description</th>
                    <th class="border px-3 py-2 text-left">Effective Date</th>
                    <th class="border px-3 py-2 text-left">Created</th>
                    <th class="border px-3 py-2 text-left">Status</th>
                    <th class="border px-3 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($policyMasters as $policyMaster)
                <tr class="hover:bg-gray-50">
                    <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                    <td class="border px-2 py-1">{{ $policyMaster->name }}</td>
                    <td class="border px-2 py-1">{{ $policyMaster->description }}</td>
                    <td class="border px-2 py-1">{{ \Carbon\Carbon::parse($policyMaster->effective_date)->format('d M Y') }}</td>
                    <td class="border px-2 py-1">{{ $policyMaster->created_at->format('d M Y') }}</td>
                    <td class="border px-2 py-1 capitalize">{{ $policyMaster->status }}</td>
                    <td class="border px-2 py-1 space-x-2">
                        <a href="#" onclick="openModal('modal-{{ $policyMaster->id }}')" class="text-blue-500 hover:underline text-xs">View</a>
                        <a href="{{ route('policy-masters.edit', $policyMaster->id) }}" class="text-yellow-500 hover:underline text-xs">Edit</a>
                        <form action="{{ route('policy-masters.destroy', $policyMaster->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline text-xs">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">No Policy Masters available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Implementation -->
    @foreach ($policyMasters as $policyMaster)
    <div id="modal-{{ $policyMaster->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-4xl p-6 relative overflow-auto max-h-[90vh] text-xs">
            <button onclick="closeModal('modal-{{ $policyMaster->id }}')" class="absolute top-2 right-4 text-xl font-bold">&times;</button>
            <h2 class="text-base font-bold mb-4">Policy Details for: {{ $policyMaster->name }}</h2>

            <!-- Modal Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-100 text-xs font-semibold">
                        <tr>
                            <th class="border px-3 py-2 text-left">Salary Head</th>
                            <th class="border px-3 py-2 text-left">Type</th>
                            <th class="border px-3 py-2 text-left">Amount / %</th>
                            <th class="border px-3 py-2 text-left">Min Service Length</th>
                            <th class="border px-3 py-2 text-left">Max Service Length</th>
                            <th class="border px-3 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($policyMaster->details as $detail)
                        <tr>
                            <td class="border px-3 py-2">{{ $detail->salaryHead->name ?? '-' }}</td>
                            <td class="border px-3 py-2 capitalize">{{ $detail->type }}</td>
                            <td class="border px-3 py-2">{{ $detail->amount }}</td>
                            <td class="border px-3 py-2">{{ $detail->min_service_length }}</td>
                            <td class="border px-3 py-2">{{ $detail->max_service_length }}</td>
                            <td class="border px-3 py-2 capitalize">{{ $detail->status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No details available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4 text-sm">
        {{ $policyMasters->links() }}
    </div>
</div>

<!-- Modal Script -->
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection
