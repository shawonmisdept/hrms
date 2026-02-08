<div id="showModal{{ $salaryGrade->id }}" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white w-full max-w-5xl p-6 rounded shadow overflow-y-auto max-h-[90vh] relative">
        <button onclick="document.getElementById('showModal{{ $salaryGrade->id }}').classList.add('hidden')" class="absolute top-2 right-4 text-gray-500 hover:text-black text-2xl font-bold">×</button>

        <h2 class="text-xl font-semibold mb-4">Salary Grade Info</h2>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div><strong>Name:</strong> {{ $salaryGrade->grade_name }}</div>
            <div><strong>Status:</strong> {{ $salaryGrade->status ? 'Active' : 'Inactive' }}</div>
            <div><strong>Created By:</strong> {{ $salaryGrade->createdBy->name ?? 'N/A' }}</div>
            <div><strong>Created:</strong> {{ $salaryGrade->created_at->format('d M, Y') }}</div>
            <div><strong>Updated:</strong> {{ $salaryGrade->updated_at->format('d M, Y') }}</div>
        </div>

        <h3 class="text-lg font-semibold mb-3">Grade Details</h3>

        <table class="w-full table-auto border border-gray-300 text-sm">
            <thead class="bg-gray-100">
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
                @foreach ($salaryGrade->salaryGradeDetails as $detail)
                <tr>
                    <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                    <td class="border px-2 py-1">{{ $detail->grade->grade_name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $detail->head->name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $detail->fixed }}</td>
                    <td class="border px-2 py-1">{{ $detail->type }}</td>
                    <td class="border px-2 py-1">{{ $detail->parentHead->name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $detail->parent_head_value }}</td>
                    <td class="border px-2 py-1">{{ $detail->is_higher ? 'Yes' : 'No' }}</td>
                    <td class="border px-2 py-1">{{ $detail->created_at->format('d M, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
