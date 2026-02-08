@extends('layouts.dashboard') 

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded shadow text-xs">
    <!-- Heading -->
    <h2 class="text-lg font-semibold mb-6">Create Policy Detail</h2>

    <!-- Form -->
    <form action="{{ route('policy-details.store') }}" method="POST" class="space-y-3">
        @csrf

        <!-- Policy Master -->
        <div>
            <label class="block font-medium mb-1">Policy Master <span class="text-red-500">*</span></label>
            <select name="policy_master_id" required class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Policy Master --</option>
                @foreach($policyMasters as $master)
                    <option value="{{ $master->id }}" {{ old('policy_master_id') == $master->id ? 'selected' : '' }}>
                        {{ $master->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Salary Head -->
        <div>
            <label class="block font-medium mb-1">Salary Head <span class="text-red-500">*</span></label>
            <select name="salary_head_id" required class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Salary Head --</option>
                @foreach($salaryHeads as $head)
                    <option value="{{ $head->id }}" {{ old('salary_head_id') == $head->id ? 'selected' : '' }}>
                        {{ $head->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Type -->
        <div>
            <label class="block font-medium mb-1">Type <span class="text-red-500">*</span></label>
            <select name="type" required class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Type --</option>
                <option value="Fixed" {{ old('type') == 'Fixed' ? 'selected' : '' }}>Fixed</option>
                <option value="Formula" {{ old('type') == 'Formula' ? 'selected' : '' }}>Formula</option>
                <option value="Percentage" {{ old('type') == 'Percentage' ? 'selected' : '' }}>Percentage</option>
            </select>
        </div>

        <!-- Amount -->
        <div>
            <label class="block font-medium mb-1">Amount / % <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Min Service Length -->
        <div>
            <label class="block font-medium mb-1">Min Service Length (days) <span class="text-red-500">*</span></label>
            <input type="number" name="min_service_length" value="{{ old('min_service_length') }}" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Max Service Length -->
        <div>
            <label class="block font-medium mb-1">Max Service Length (days) <span class="text-red-500">*</span></label>
            <input type="number" name="max_service_length" value="{{ old('max_service_length') }}" required class="w-full border border-gray-300 rounded px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Status -->
        <div>
            <label class="block font-medium mb-1">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 pt-2">
            <a href="{{ route('policy-details.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded text-xs">Back</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">Save</button>
        </div>
    </form>
</div>
@endsection
