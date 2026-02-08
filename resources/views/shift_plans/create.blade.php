@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[80%] mx-auto">
    

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('shift_plans.store') }}" method="POST" class="space-y-5">
            @csrf
            <h1 class="text-2xl font-bold mb-6">Create Shift Plan</h1>
            {{-- Shift Name --}}
            <div class="mb-4">
                <label for="name" class="block text-xs font-bold mb-1">Shift Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Start and End Time --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="start_time" class="block text-xs font-bold mb-1">Start Time <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500" required>
                    @error('start_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block text-xs font-bold mb-1">End Time <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500" required>
                    @error('end_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="block text-xs font-bold mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-6 w-1/5">
                <label for="status" class="block text-xs font-bold mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit & Back Button একই লাইনে --}}
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('shift_plans.index') }}"
                    class="inline-block bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded">
                    ← Back
                </a>
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-5 py-1 rounded transition-all">
                    Create
                </button>
            </div>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
