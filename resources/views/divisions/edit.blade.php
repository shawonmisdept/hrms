@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded border border-gray-300 shadow-sm p-5">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Edit Division</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-800 p-3 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('divisions.update', $division->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" required value="{{ old('name', $division->name) }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-2 py-1 text-sm">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Code</label>
            <input type="text" name="code" value="{{ old('code', $division->code) }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-2 py-1 text-sm">
            @error('code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-2 py-1 text-sm">{{ old('description', $division->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Manager (Employee)</label>
            <select name="manager_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-2 py-1 text-sm">
                <option value="">-- Select Manager --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ old('manager_id', $division->manager_id) == $employee->id ? 'selected' : '' }}>
                        {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }} ({{ $employee->employee_code }})
                    </option>
                @endforeach
            </select>
            @error('manager_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Manager Email</label>
                <input type="email" name="manager_email" value="{{ old('manager_email', $division->manager_email) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-2 py-1 text-sm">
                @error('manager_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Manager Phone</label>
                <input type="text" name="manager_phone" value="{{ old('manager_phone', $division->manager_phone) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-2 py-1 text-sm">
                @error('manager_phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-2 py-1 text-sm">
                <option value="active" {{ old('status', $division->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $division->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="blocked" {{ old('status', $division->status) == 'blocked' ? 'selected' : '' }}>Blocked</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('divisions.index') }}" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm">Cancel</a>
            <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Update</button>
        </div>
    </form>
</div>
@endsection
