@extends('layouts.dashboard') 

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded shadow text-xs">
    <h2 class="text-xl font-bold mb-6">Edit Policy Detail</h2>

    <!-- Edit Form -->
    <form action="{{ route('policy-details.update', $policyDetail->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Policy Master -->
        <div>
            <label class="block font-medium mb-1">Policy Master <span class="text-red-500">*</span></label>
            <select name="policy_master_id" class="w-full border rounded px-2 py-1" required>
                @foreach($policyMasters as $policyMaster)
                    <option value="{{ $policyMaster->id }}" {{ $policyMaster->id == old('policy_master_id', $policyDetail->policy_master_id) ? 'selected' : '' }}>
                        {{ $policyMaster->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Salary Head -->
        <div>
            <label class="block font-medium mb-1">Salary Head <span class="text-red-500">*</span></label>
            <select name="salary_head_id" class="w-full border rounded px-2 py-1" required>
                @foreach($salaryHeads as $salaryHead)
                    <option value="{{ $salaryHead->id }}" {{ $salaryHead->id == old('salary_head_id', $policyDetail->salary_head_id) ? 'selected' : '' }}>
                        {{ $salaryHead->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Type -->
        <div>
            <label class="block font-medium mb-1">Type <span class="text-red-500">*</span></label>
            <select name="type" class="w-full border rounded px-2 py-1" required>
                <option value="Fixed" {{ old('type', $policyDetail->type) == 'Fixed' ? 'selected' : '' }}>Fixed</option>
                <option value="Formula" {{ old('type', $policyDetail->type) == 'Formula' ? 'selected' : '' }}>Formula</option>
                <option value="Percentage" {{ old('type', $policyDetail->type) == 'Percentage' ? 'selected' : '' }}>Percentage</option>
            </select>
        </div>

        <!-- Amount -->
        <div>
            <label class="block font-medium mb-1">Amount / % <span class="text-red-500">*</span></label>
            <input type="number" name="amount" value="{{ old('amount', $policyDetail->amount) }}" required class="w-full border rounded px-2 py-1 text-xs">
        </div>

        <!-- Min Service Length -->
        <div>
            <label class="block font-medium mb-1">Min Service Length (in days) <span class="text-red-500">*</span></label>
            <input type="number" name="min_service_length" value="{{ old('min_service_length', $policyDetail->min_service_length) }}" required class="w-full border rounded px-2 py-1 text-xs">
        </div>

        <!-- Max Service Length -->
        <div>
            <label class="block font-medium mb-1">Max Service Length (in days) <span class="text-red-500">*</span></label>
            <input type="number" name="max_service_length" value="{{ old('max_service_length', $policyDetail->max_service_length) }}" required class="w-full border rounded px-2 py-1 text-xs">
        </div>

        <!-- Status -->
        <div>
            <label class="block font-medium mb-1">Status <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border rounded px-2 py-1" required>
                <option value="active" {{ old('status', $policyDetail->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $policyDetail->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="blocked" {{ old('status', $policyDetail->status) == 'blocked' ? 'selected' : '' }}>Blocked</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex justify-end space-x-2 pt-4">
            <a href="{{ route('policy-details.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded text-xs">Back</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">Save</button>
        </div>
    </form>
</div>
@endsection
