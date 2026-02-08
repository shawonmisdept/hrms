@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[60%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Edit Staff Category</h1>

        <form action="{{ route('staff_categories.update', $staffCategory->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Staff Category Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $staffCategory->name) }}" required
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">{{ old('description', $staffCategory->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
                    <option value="1" {{ old('status', $staffCategory->status) == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $staffCategory->status) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('staff_categories.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    ← Back
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
