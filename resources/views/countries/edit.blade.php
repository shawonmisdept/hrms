@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[60%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Edit Country</h1>

        <form action="{{ route('countries.update', $country->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            {{-- 1. Country Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Country Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $country->name) }}" required
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- 2. Native Name --}}
            <div>
                <label for="native_name" class="block text-sm font-medium text-gray-700">Native Name</label>
                <input type="text" name="native_name" id="native_name" value="{{ old('native_name', $country->native_name) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- 3. Country Code --}}
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Country Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $country->code) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
            </div>

            {{-- 4. Phone Code --}}
            <div>
                <label for="phone_code" class="block text-sm font-medium text-gray-700">Phone Code</label>
                <input type="text" name="phone_code" id="phone_code" value="{{ old('phone_code', $country->phone_code) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
            </div>

            {{-- 5. Currency Code --}}
            <div>
                <label for="currency_code" class="block text-sm font-medium text-gray-700">Currency Code</label>
                <input type="text" name="currency_code" id="currency_code" value="{{ old('currency_code', $country->currency_code) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
            </div>

            {{-- 6. Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="1" {{ $country->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $country->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="col-span-2 flex justify-between items-center pt-4">
                <a href="{{ route('countries.index') }}"
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
