@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[80%] mx-auto">

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">

        {{-- Title --}}
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Edit Department</h1>

        {{-- Form --}}
        <form action="{{ route('departments.update', $department->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            {{-- Department Name --}}
            <div class="col-span-1">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Department Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500 hover:border-green-400"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Department Head --}}
            <div class="col-span-1">
                <label for="department_head_id" class="block text-sm font-medium text-gray-700 mb-1">Department Head</label>
                <input type="text" name="department_head_id" id="department_head_id"
                    value="{{ old('department_head_id', $department->department_head_id) }}"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 hover:border-blue-400">
                @error('department_head_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="col-span-1">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email"
                    value="{{ old('email', $department->email) }}"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 hover:border-blue-400">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500 hover:border-green-400"
                    required>
                    <option value="1" {{ old('status', $department->status) == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $department->status) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="col-span-1 md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500 hover:border-green-400">{{ old('description', $department->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Footer Buttons --}}
            <div class="col-span-1 md:col-span-2 flex justify-between items-center pt-4">
                {{-- Back Button --}}
                <a href="{{ route('departments.index') }}"
                class="inline-block bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    ← Back
                </a>

                {{-- Submit Button --}}
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded shadow transition-all">
                    ✅ Update
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
