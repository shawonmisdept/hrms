@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[60%] mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Weekend</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-end mb-6">
            <a href="{{ route('weekends.index') }}"
                class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded">
                ← Back
            </a>
        </div>

        <form action="{{ route('weekends.update', $weekend->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs font-bold mb-1">Weekend Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $weekend->name) }}"
                    class="w-full border border-gray-300 rounded px-3 py-1 text-sm" required>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-xs font-bold mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-1 text-sm">{{ old('description', $weekend->description) }}</textarea>
            </div>

            {{-- Status --}}
            <div class="mb-6 w-1/5">
                <label for="status" class="block text-xs font-bold mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded px-3 py-1 text-sm" required>
                    <option value="active" {{ old('status', $weekend->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $weekend->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-5 py-1 rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
