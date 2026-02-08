@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[80%] mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Shift Plan</h1>

        <form action="{{ route('shift_plans.update', $shiftPlan->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Shift Name --}}
            <div>
                <label for="name" class="block text-xs font-bold mb-1">Shift Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $shiftPlan->name) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Start and End Time --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-xs font-bold mb-1">Start Time <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" id="start_time"
                        value="{{ old('start_time', \Carbon\Carbon::parse($shiftPlan->start_time)->format('H:i')) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500" required>
                    @error('start_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-xs font-bold mb-1">End Time <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" id="end_time"
                        value="{{ old('end_time', \Carbon\Carbon::parse($shiftPlan->end_time)->format('H:i')) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500" required>
                    @error('end_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-xs font-bold mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500">{{ old('description', $shiftPlan->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-xs font-bold mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500" required>
                    <option value="active" {{ old('status', $shiftPlan->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $shiftPlan->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('shift_plans.index') }}"
                    class="inline-block bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded">
                    ← Back
                </a>
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-5 py-1 rounded transition-all">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
