@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto mt-8 bg-white p-6 rounded shadow text-xs">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-base font-bold">Salary Grades</h2>
        <a href="{{ route('salary-grades.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded text-xs">+ Create</a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-xs">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-xs">
            <thead class="bg-gray-100 font-semibold">
                <tr>
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">Name</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Created By</th>
                    <th class="border px-3 py-2">Created At</th>
                    <th class="border px-3 py-2 w-px whitespace-nowrap text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaryGrades as $grade)
                <tr>
                    <td class="border px-3 py-1">{{ $loop->iteration }}</td>
                    <td class="border px-3 py-1">{{ $grade->grade_name }}</td>
                    <td class="border px-3 py-1">{{ $grade->status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td class="border px-3 py-1">{{ $grade->createdByUser->name ?? 'N/A' }}</div>
                    <td class="border px-3 py-1">{{ $grade->created_at->format('d M Y') }}</td>
                    <td class="border px-2 py-1 w-px whitespace-nowrap text-center space-x-1">
    <button onclick="openModal('modal-{{ $grade->id }}')" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-0.5 rounded text-xs">View</button>
    <a href="{{ route('salary-grades.edit', $grade->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-0.5 rounded text-xs">Edit</a>
    <form action="{{ route('salary-grades.destroy', $grade->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-0.5 rounded text-xs">Delete</button>
    </form>
</td>

                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-gray-500">No Salary Grades Found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modals -->
    @foreach ($salaryGrades as $grade)
    <div id="modal-{{ $grade->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-4xl p-6 relative overflow-auto max-h-[90vh] text-xs">
            <button onclick="closeModal('modal-{{ $grade->id }}')" class="absolute top-2 right-4 text-xl font-bold">&times;</button>

            <h2 class="text-base font-bold mb-3">Salary Grade Info</h2>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><strong>Name:</strong> {{ $grade->grade_name }}</div>
                <div><strong>Status:</strong> {{ $grade->status == 1 ? 'Active' : 'Inactive' }}</div>
                <div><strong>Created By:</strong> {{ $grade->createdByUser->name ?? 'N/A' }}</div>
                <div><strong>Created:</strong> {{ $grade->created_at->format('d M Y') }}</div>
                <div><strong>Updated:</strong> {{ $grade->updated_at->format('d M Y') }}</div>
            </div>

            <h2 class="text-base font-bold mb-2 mt-4">Grade Details</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 text-xs">
                    <thead class="bg-gray-100 font-semibold">
                        <tr>
                            <th class="border px-2 py-1">#</th>
                            <th class="border px-2 py-1">Grade</th>
                            <th class="border px-2 py-1">Head</th>
                            <th class="border px-2 py-1">Fixed</th>
                            <th class="border px-2 py-1">Type</th>
                            <th class="border px-2 py-1">Parent Head</th>
                            <th class="border px-2 py-1">Value / Formula</th>
                            <th class="border px-2 py-1">Is Higher</th>
                            <th class="border px-2 py-1">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grade->details as $index => $detail)
                        <tr>
                            <td class="border px-2 py-1">{{ $index + 1 }}</td>
                            <td class="border px-2 py-1">{{ $detail->grade_name }}</td>
                            <td class="border px-2 py-1">{{ $detail->head->name ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ $detail->fixed == 1 ? 'Yes' : 'No' }}</td>
                            <td class="border px-2 py-1 capitalize">{{ $detail->type }}</td>
                            <td class="border px-2 py-1">{{ $detail->parentHead->name ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ $detail->formula ?? $detail->parent_head_value }}</td>
                            <td class="border px-2 py-1">{{ $detail->is_higher == 1 ? 'Yes' : 'No' }}</td>
                            <td class="border px-2 py-1">{{ $detail->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center py-4 text-gray-500">No grade details available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $salaryGrades->links() }}
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection
