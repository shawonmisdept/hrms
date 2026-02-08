@extends('layouts.dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Left side: Edit Form -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Edit Salary Grade Detail</h2>

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

        <form method="POST" action="{{ route('salary-grade-details.update', $detail->id) }}">
            @csrf
            @method('PUT')

            <!-- Grade -->
            <div class="mb-4">
                <label for="grade_id" class="block font-medium">Grade <span class="text-red-500">*</span></label>
                <select id="grade_id" name="grade_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Grade</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ $grade->id == $detail->grade_id ? 'selected' : '' }}>
                            {{ $grade->grade_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Head -->
            <div class="mb-4">
                <label for="head_id" class="block font-medium">Salary Head <span class="text-red-500">*</span></label>
                <select id="head_id" name="head_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Head</option>
                    @foreach($heads as $head)
                        <option value="{{ $head->id }}" {{ $head->id == $detail->head_id ? 'selected' : '' }}>
                            {{ $head->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Fixed -->
            <div class="mb-4">
                <label for="fixed" class="block font-medium">Fixed <span class="text-red-500">*</span></label>
                <select id="fixed" name="fixed" class="w-full border p-2 rounded" required>
                    <option value="1" {{ $detail->fixed == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $detail->fixed == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label for="type" class="block font-medium">Type</label>
                <select id="type" name="type" class="w-full border p-2 rounded">
                    <option value="F" {{ $detail->type == 'F' ? 'selected' : '' }}>Fixed</option>
                    <option value="M" {{ $detail->type == 'M' ? 'selected' : '' }}>Formula</option>
                    <option value="%" {{ $detail->type == '%' ? 'selected' : '' }}>Percentage</option>
                </select>
            </div>

            <!-- Formula Field -->
            <div class="mb-4 hidden" id="formula-field">
                <label for="formula" class="block font-medium">Formula</label>
                <input type="text" id="formula" name="formula" class="w-full border p-2 rounded" placeholder="e.g. (<GROSS>-(<MEDICAL>+<FOOD>))/1.4" value="{{ old('formula', $detail->formula) }}">
            </div>

            <!-- Parent Head -->
            <div class="mb-4 hidden" id="parent-head-field">
                <label for="parent_head_id" class="block font-medium">Parent Salary Head</label>
                <select id="parent_head_id" name="parent_head_id" class="w-full border p-2 rounded">
                    <option value="">Select Parent Head</option>
                    @foreach($heads as $head)
                        <option value="{{ $head->id }}" {{ $head->id == $detail->parent_head_id ? 'selected' : '' }}>
                            {{ $head->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Parent Head Value -->
            <div class="mb-4 hidden" id="parent-value-field">
                <label for="parent_head_value" class="block font-medium">Parent Head Value</label>
                <input type="number" id="parent_head_value" name="parent_head_value" step="any" class="w-full border p-2 rounded" value="{{ old('parent_head_value', $detail->parent_head_value) }}">
            </div>

            <!-- Is Higher -->
            <div class="mb-4">
                <label for="is_higher" class="block font-medium">Is Higher?</label>
                <select id="is_higher" name="is_higher" class="w-full border p-2 rounded">
                    <option value="0" {{ $detail->is_higher == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $detail->is_higher == 1 ? 'selected' : '' }}>Yes</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex justify-between">
                <a href="{{ route('salary-grade-details.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded">Back</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
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
        const typeSelect = document.getElementById('type');
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
