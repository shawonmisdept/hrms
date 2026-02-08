@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[60%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Create Overtime Slab</h1>

        <form method="POST" action="{{ route('overtime-slabs.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            {{-- 1. Name --}}
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- 2. Rate --}}
            <div class="md:col-span-2">
                <label for="rate" class="block text-sm font-medium text-gray-700">Rate (৳)</label>
                <input type="number" name="rate" id="rate" value="{{ old('rate') }}" step="0.01"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- 3. Assign Employees --}}
            <div class="md:col-span-2">
                <label for="employee_ids" class="block text-sm font-medium text-gray-700">Assign Employees</label>
                <select name="employee_ids[]" id="employee_ids" multiple
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Submit --}}
            <div class="col-span-2 flex justify-between items-center pt-4">
                <a href="{{ route('overtime-slabs.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    ← Back
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    💾 Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
