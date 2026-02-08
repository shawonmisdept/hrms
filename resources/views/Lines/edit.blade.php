@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Line</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-800 p-3 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lines.update', $line->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $line->name) }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Code <span class="text-red-500">*</span></label>
            <input type="text" name="code" value="{{ old('code', $line->code) }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500">{{ old('description', $line->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Manager (Employee) <span class="text-red-500">*</span></label>
            <select name="manager_id"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500" required>
                <option value="">-- Select Employee --</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}"
                        {{ old('manager_id', $line->manager_id) == $employee->id ? 'selected' : '' }}>
                        {{ $employee->employee_code }} - {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Manager Email</label>
            <input type="email" name="manager_email" value="{{ old('manager_email', $line->manager_email) }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Manager Phone</label>
            <input type="text" name="manager_phone" value="{{ old('manager_phone', $line->manager_phone) }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
            <select name="status"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500" required>
                <option value="active" {{ old('status', $line->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $line->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('lines.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                ← Back
            </a>
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded text-sm">
                Update Line
            </button>
        </div>
    </form>
</div>
@endsection
