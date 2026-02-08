@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Create Insurance</h2>

    <form action="{{ route('insurances.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required value="{{ old('name') }}">
            </div>

            <div>
                <label class="block font-semibold">Provider Name</label>
                <input type="text" name="provider_name" class="w-full border rounded px-3 py-2" value="{{ old('provider_name') }}">
            </div>

            <div>
                <label class="block font-semibold">Coverage Amount</label>
                <input type="number" step="0.01" name="coverage_amount" class="w-full border rounded px-3 py-2" value="{{ old('coverage_amount') }}">
            </div>

            <div>
                <label class="block font-semibold">Premium</label>
                <input type="number" step="0.01" name="premium" class="w-full border rounded px-3 py-2" value="{{ old('premium') }}">
            </div>

            <div>
                <label class="block font-semibold">Start Date</label>
                <input type="date" name="start_date" class="w-full border rounded px-3 py-2" value="{{ old('start_date') }}">
            </div>

            <div>
                <label class="block font-semibold">End Date</label>
                <input type="date" name="end_date" class="w-full border rounded px-3 py-2" value="{{ old('end_date') }}">
            </div>

            <div>
                <label class="block font-semibold">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('insurances.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded mr-2">Back</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
        </div>
    </form>
</div>
@endsection
