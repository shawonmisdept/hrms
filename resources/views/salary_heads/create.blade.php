@extends('layouts.Dashboard')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">
        {{ isset($salaryHead) ? 'Edit Salary Head' : 'Create Salary Head' }}
    </h2>

    <form method="POST" action="{{ isset($salaryHead) ? route('salary_heads.update', $salaryHead->id) : route('salary_heads.store') }}">
        @csrf
        @if(isset($salaryHead))
            @method('PUT')
        @endif

        {{-- Name --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-sm">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $salaryHead->name ?? '') }}"
                class="w-full border px-3  py-1 rounded text-sm" required>
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-sm">Description</label>
            <textarea name="description" class="w-full border px-3  py-1 rounded text-sm" rows="2">{{ old('description', $salaryHead->description ?? '') }}</textarea>
        </div>

        {{-- Head Type --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-sm">Head Type</label>
            <select name="head_type" class="w-full border px-3  py-1 rounded text-sm">
                @php
                    $headTypes = ['basic', 'gross', 'house_rent', 'conveyance', 'medical', 'food', 'stamp', 'performance_bonus', 'other_allowance', 'lunch', 'mobile_bill', 'income_tax', 'dearness_allowance', null];
                @endphp
                <option value="">-- Select --</option>
                @foreach($headTypes as $type)
                    <option value="{{ $type }}" {{ old('head_type', $salaryHead->head_type ?? '') == $type ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $type ?? 'None')) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Perquisite --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-sm">Perquisite</label>
            <select name="perquisite" class="w-full border px-3  py-1 rounded text-sm">
                <option value="no" {{ old('perquisite', $salaryHead->perquisite ?? '') == 'no' ? 'selected' : '' }}>No</option>
                <option value="yes" {{ old('perquisite', $salaryHead->perquisite ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        {{-- Disburse --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-sm">Disburse</label>
            <select name="disburse" class="w-full border px-3  py-1 rounded text-sm">
                <option value="no" {{ old('disburse', $salaryHead->disburse ?? '') == 'no' ? 'selected' : '' }}>No</option>
                <option value="yes" {{ old('disburse', $salaryHead->disburse ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        {{-- Sequence --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-sm">Sequence</label>
            <input type="number" name="sequence" value="{{ old('sequence', $salaryHead->sequence ?? '') }}"
                class="w-full border px-3  py-1 rounded text-sm">
        </div>

        {{-- Sort Code --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-sm">Sort Code</label>
            <input type="text" name="sort_code" value="{{ old('sort_code', $salaryHead->sort_code ?? '') }}"
                class="w-full border px-3  py-1 rounded text-sm">
        </div>

        {{-- Status --}}
        <div class="mb-6">
            <label class="block mb-1 font-medium text-sm">Status</label>
            <select name="status" class="w-full border px-3  py-1 rounded text-sm">
                <option value="1" {{ old('status', $salaryHead->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $salaryHead->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between">
            <a href="{{ route('salary_heads.index') }}" class="px-4 py-1 bg-gray-500 hover:bg-gray-600 text-white rounded text-sm">Back</a>
            <button type="submit" class="px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                {{ isset($salaryHead) ? 'Update' : 'Save' }}
            </button>
        </div>
    </form>
</div>
@endsection
