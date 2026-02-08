@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[80%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Edit District</h1>

        <form action="{{ route('districts.update', $district->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">District Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $district->name) }}" required
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            <div>
                <label for="country_id" class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
                <select name="country_id" id="country_id" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="">Select</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id', $district->country_id) == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="active" {{ old('status', $district->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $district->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-span-2 flex justify-between items-center pt-4">
                <a href="{{ route('districts.index') }}"
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
