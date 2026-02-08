<h2 class="text-lg font-bold mb-4">Salary Grade Info</h2>

<div class="grid grid-cols-2 gap-4 mb-4 text-sm">
    <div><strong>Name:</strong> {{ $salaryGrade->grade_name }}</div>
    <div><strong>Status:</strong> {{ $salaryGrade->status ? 'Active' : 'Inactive' }}</div>
    <div><strong>Created By:</strong> {{ $salaryGrade->createdBy->name ?? 'N/A' }}</div>
    <div><strong>Created:</strong> {{ $salaryGrade->created_at->format('d M, Y') }}</div>
</div>

<h3 class="text-base font-semibold mb-2">Grade Details</h3>

<table class="w-full table-auto border border-gray-300 text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-2 py-1">#</th>
            <th class="border px-2 py-1">Head</th>
            <th class="border px-2 py-1">Fixed</th>
            <th class="border px-2 py-1">Type</th>
            <th class="border px-2 py-1">Parent Head</th>
            <th class="border px-2 py-1">Value</th>
            <th class="border px-2 py-1">Is Higher</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salaryGrade->salaryGradeDetails as $detail)
        <tr>
            <td class="border px-2 py-1">{{ $loop->iteration }}</td>
            <td class="border px-2 py-1">{{ $detail->head->name ?? '-' }}</td>
            <td class="border px-2 py-1">{{ $detail->fixed }}</td>
            <td class="border px-2 py-1">{{ $detail->type }}</td>
            <td class="border px-2 py-1">{{ $detail->parentHead->name ?? '-' }}</td>
            <td class="border px-2 py-1">{{ $detail->parent_head_value }}</td>
            <td class="border px-2 py-1">{{ $detail->is_higher ? 'Yes' : 'No' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
