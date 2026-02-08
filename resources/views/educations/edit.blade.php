@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[80%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Edit Education</h1>

        <form action="{{ route('education.update', $education->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            {{-- Unit --}}
            <div>
                <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit <span class="text-red-500">*</span></label>
                <select name="unit_id" id="unit_id" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id', $education->unit_id) == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Education Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $education->name) }}" required
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- Native Name --}}
            <div>
                <label for="native_name" class="block text-sm font-medium text-gray-700">Native Name</label>
                <input type="text" name="native_name" id="native_name" value="{{ old('native_name', $education->native_name) }}"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="1" {{ old('status', $education->status) == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $education->status) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-span-2 flex justify-between items-center pt-4">
                <a href="{{ route('education.index') }}"
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
