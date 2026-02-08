@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto p-4 bg-white rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-4 text-gray-800">Edit Section</h2>

    <form action="{{ route('sections.update', $section->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Section Name --}}
        <div class="mb-3">
            <label for="name" class="block text-sm font-medium text-gray-700">Section Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" required
                   class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('name', $section->name) }}">
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $section->description) }}</textarea>
        </div>

        {{-- Manager --}}
        <div class="mb-3">
            <label for="manager_id" class="block text-sm font-medium text-gray-700">Manager (Employee Code) <span class="text-red-500">*</span></label>
            <select name="manager_id" id="manager_id" required
                    class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Select Manager --</option>
                @foreach ($employees as $emp)
                    <option value="{{ $emp->employee_code }}" {{ old('manager_id') == $emp->employee_code ? 'selected' : '' }}>
                        {{ $emp->employee_code }} - {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Manager Email --}}
        <div class="mb-3">
            <label for="manager_email" class="block text-sm font-medium text-gray-700">Manager Email</label>
            <input type="email" name="manager_email" id="manager_email"
                   class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('manager_email', $section->manager_email) }}">
        </div>

        {{-- Manager Phone --}}
        <div class="mb-3">
            <label for="manager_phone" class="block text-sm font-medium text-gray-700">Manager Phone</label>
            <input type="text" name="manager_phone" id="manager_phone"
                   class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('manager_phone', $section->manager_phone) }}">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                    class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500">
                <option value="Active" {{ old('status', $section->status) == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('status', $section->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="Blocked" {{ old('status', $section->status) == 'Blocked' ? 'selected' : '' }}>Blocked</option>
            </select>
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end mt-4">
            <a href="{{ route('sections.index') }}"
               class="mr-3 px-4 py-2 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">Cancel</a>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
