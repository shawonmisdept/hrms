@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[50%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Edit Upazila</h1>

        <form action="{{ route('upazilas.update', $upazila->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            {{-- 1. District --}}
            <div class="md:col-span-2">
                <label for="district_id" class="block text-sm font-medium text-gray-700">District <span class="text-red-500">*</span></label>
                <select name="district_id" id="district_id" required
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="">Select</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ $upazila->district_id == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. Upazila Name --}}
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Upazila Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $upazila->name) }}" required
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- 3. Status --}}
            <div class="md:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="1" {{ $upazila->status == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $upazila->status == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="col-span-2 flex justify-between items-center pt-4">
                <a href="{{ route('upazilas.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    ← Back
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
