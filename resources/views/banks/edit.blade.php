@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[60%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Edit Bank</h1>

        <form action="{{ route('banks.update', $bank->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            {{-- 1. Bank Name --}}
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Bank Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $bank->name) }}" required
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- 2. Short Name --}}
            <div class="md:col-span-2">
                <label for="short_name" class="block text-sm font-medium text-gray-700">Short Name <span class="text-red-500">*</span></label>
                <input type="text" name="short_name" id="short_name" value="{{ old('short_name', $bank->short_name) }}" required
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- 3. Status --}}
            <div class="md:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="1" {{ $bank->status == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $bank->status == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="col-span-2 flex justify-between items-center pt-4">
                <a href="{{ route('banks.index') }}"
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
