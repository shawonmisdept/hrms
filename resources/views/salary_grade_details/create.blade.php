@extends('layouts.dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Left side: Create Form -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Create Salary Grade Detail</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('salary-grade-details.store') }}">
            @csrf

            <!-- Grade -->
            <div class="mb-4">
                <label class="block font-medium">Grade <span class="text-red-500">*</span></label>
                <select name="grade_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Grade</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Head -->
            <div class="mb-4">
                <label class="block font-medium">Salary Head <span class="text-red-500">*</span></label>
                <select name="head_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Head</option>
                    @foreach($heads as $head)
                        <option value="{{ $head->id }}">{{ $head->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fixed -->
            <div class="mb-4">
                <label class="block font-medium">Fixed <span class="text-red-500">*</span></label>
                <select name="fixed" class="w-full border p-2 rounded" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label class="block font-medium">Type</label>
                <select name="type" class="w-full border p-2 rounded" id="type-select">
                    <option value="">Select Type</option>
                    <option value="F">Fixed</option>
                    <option value="M">Formula</option>
                    <option value="%">Percentage</option>
                </select>
            </div>

            <!-- Formula Field -->
            <div class="mb-4 hidden" id="formula-field">
                <label class="block font-medium">Formula</label>
                <input type="text" name="formula" class="w-full border p-2 rounded" placeholder="e.g. (<GROSS>-(<MEDICAL>+<FOOD>))/1.4">
            </div>

            <!-- Parent Head -->
            <div class="mb-4 hidden" id="parent-head-field">
                <label class="block font-medium">Parent Salary Head</label>
                <select name="parent_head_id" class="w-full border p-2 rounded">
                    <option value="">Select Parent Head</option>
                    @foreach($heads as $head)
                        <option value="{{ $head->id }}">{{ $head->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Parent Head Value -->
            <div class="mb-4 hidden" id="parent-value-field">
                <label class="block font-medium">Parent Head Value</label>
                <input type="number" step="any" name="parent_head_value" class="w-full border p-2 rounded">
            </div>

            <!-- Is Higher -->
            <div class="mb-4">
                <label class="block font-medium">Is Higher?</label>
                <select name="is_higher" class="w-full border p-2 rounded">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex justify-between">
                <a href="{{ route('salary-grade-details.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded">Back</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>

    <!-- Right side: Salary Head Table -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Salary Head List</h2>
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">Sequence</th>
                    <th class="px-4 py-2 border">Head Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($heads as $head)
                    <tr>
                        <td class="px-4 py-2 border">{{ $head->sequence }}</td>
                        <td class="px-4 py-2 border">{{ $head->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script for Conditional Fields -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type-select');
        const formulaField = document.getElementById('formula-field');
        const parentHeadField = document.getElementById('parent-head-field');
        const parentValueField = document.getElementById('parent-value-field');

        typeSelect.addEventListener('change', function () {
            const type = this.value;

            formulaField.classList.add('hidden');
            parentHeadField.classList.add('hidden');
            parentValueField.classList.add('hidden');

            if (type === 'M') {
                formulaField.classList.remove('hidden');
            } else if (type === '%') {
                parentHeadField.classList.remove('hidden');
                parentValueField.classList.remove('hidden');
            } else if (type === 'F') {
                parentValueField.classList.remove('hidden');
            }
        });
    });
</script>
@endsection
