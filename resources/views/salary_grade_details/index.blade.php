@extends('layouts.dashboard')

@section('content')

<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Salary Grade Details</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grade Filter -->
    <form method="GET" class="mb-4 flex flex-wrap gap-2 items-center">
        <label for="grade_id" class="font-medium">Filter by Grade:</label>
        <select name="grade_id" onchange="this.form.submit()" class="border p-1 rounded">
            <option value="">All Grades</option>
            @foreach($grades as $grade)
                <option value="{{ $grade->id }}" {{ $selectedGrade == $grade->id ? 'selected' : '' }}>
                    {{ $grade->grade_name }}
                </option>
            @endforeach
        </select>
        <a href="{{ route('salary-grade-details.create') }}" class="ml-auto bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">+ Add New</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Grade</th>
                    <th class="px-4 py-2 border">Head</th>
                    <th class="px-4 py-2 border">Fixed</th>
                    <th class="px-4 py-2 border">Type</th>
                    <th class="px-4 py-2 border">Parent Head</th>
                    <th class="px-4 py-2 border">Value / Formula</th>
                    <th class="px-4 py-2 border">Is Higher</th>
                    <th class="px-4 py-2 border">Created At</th>
                    <th class="border px-3 py-2 w-px whitespace-nowrap text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($details as $index => $detail)
                    <tr>
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $detail->grade->grade_name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $detail->head->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $detail->fixed ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-2 border">{{ $detail->type ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $detail->parentHead->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">
                            @if($detail->type === 'M')
                                <span class="text-blue-600 italic">{{ $detail->formula }}</span>
                            @else
                                {{ $detail->parent_head_value ?? '-' }}
                            @endif
                        </td>
                        <td class="px-4 py-2 border">{{ $detail->is_higher ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-2 border">{{ $detail->created_at->format('d M Y') }}</td>
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
                    <tr>
                        <td colspan="10" class="text-center py-4 text-gray-500">No details found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
