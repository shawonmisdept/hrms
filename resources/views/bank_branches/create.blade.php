@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[60%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Create Bank Branch</h1>

        <form action="{{ route('bank_branches.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Bank --}}
            <div>
                <label for="bank_id" class="block text-sm font-medium text-gray-700">Bank <span class="text-red-500">*</span></label>
                <select name="bank_id" id="bank_id" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
                    @foreach($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Branch Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Branch Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('bank_branches.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    ← Back
                </a>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    ➕ Create
                </button>
            </div>
        </form>
    </div>
</div>
@endsection