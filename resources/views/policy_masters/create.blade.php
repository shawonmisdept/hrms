@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded shadow text-xs">
    <h2 class="text-base font-bold mb-4">Create Policy Master</h2>

    <form action="{{ route('policy-masters.store') }}" method="POST">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label class="block font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-2 py-1.5 text-xs">
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" class="w-full border rounded px-2 py-1.5 text-xs">{{ old('description') }}</textarea>
        </div>

        <!-- Avail From -->
        <div class="mb-3">
            <label class="block font-medium mb-1">Avail From <span class="text-red-500">*</span></label>
            <div class="flex items-center gap-3 text-xs">
                <label class="flex items-center gap-1">
                    <input type="radio" name="avail_from" value="date_of_join" {{ old('avail_from') == 'date_of_join' ? 'checked' : '' }} required>
                    Date of Join
                </label>
                <label class="flex items-center gap-1">
                    <input type="radio" name="avail_from" value="date_of_confirmation" {{ old('avail_from') == 'date_of_confirmation' ? 'checked' : '' }} required>
                    Date of Confirmation
                </label>
            </div>
        </div>

        <!-- Effective Date -->
        <div class="mb-3">
            <label class="block font-medium mb-1">Effective Date <span class="text-red-500">*</span></label>
            <input type="date" name="effective_date" value="{{ old('effective_date') }}" required class="w-full border rounded px-2 py-1.5 text-xs">
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label class="block font-medium mb-1">Status <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border rounded px-2 py-1.5 text-xs" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-2">
            <a href="{{ route('policy-masters.index') }}" class="bg-gray-300 px-3 py-1.5 rounded text-xs">Back</a>
            <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs">Save</button>
        </div>
    </form>
</div>
@endsection
