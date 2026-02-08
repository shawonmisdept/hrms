@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[60%] mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">Edit Bank Branch</h1>

        <form action="{{ route('bank_branches.update', $bankBranch->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Bank --}}
            <div>
                <label for="bank_id" class="block text-sm font-medium text-gray-700">Bank <span class="text-red-500">*</span></label>
                <select name="bank_id" id="bank_id" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
                    @foreach($banks as $bank)
                        <option value="{{ $bank->id }}" {{ $bankBranch->bank_id == $bank->id ? 'selected' : '' }}>
                            {{ $bank->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Branch Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Branch Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name', $bankBranch->name) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-green-200 focus:border-green-500">
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="1" {{ $bankBranch->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$bankBranch->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Submit & Back --}}
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('bank_branches.index') }}"
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
