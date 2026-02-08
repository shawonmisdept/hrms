@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Create Section</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sections.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Section Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" required
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                   value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="manager_id" class="block text-sm font-medium text-gray-700">Manager (Employee) <span class="text-red-500">*</span></label>
            <select name="manager_id" id="manager_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="">-- Select Manager --</option>
                @foreach ($employees as $emp)
                    <option value="{{ $emp->id }}" {{ old('manager_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->employee_code }} - {{ $emp->first_name }} {{ $emp->middle_name }} {{ $emp->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="manager_email" class="block text-sm font-medium text-gray-700">Manager Email</label>
            <input type="email" name="manager_email" id="manager_email"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                   value="{{ old('manager_email') }}">
        </div>

        <div class="mb-4">
            <label for="manager_phone" class="block text-sm font-medium text-gray-700">Manager Phone</label>
            <input type="text" name="manager_phone" id="manager_phone"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                   value="{{ old('manager_phone') }}">
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="Blocked" {{ old('status') == 'Blocked' ? 'selected' : '' }}>Blocked</option>
            </select>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('sections.index') }}"
               class="inline-block px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100">Cancel</a>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>
    </form>
</div>
@endsection
