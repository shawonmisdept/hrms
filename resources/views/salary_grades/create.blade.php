@extends('layouts.dashboard')

@section('content')
<div class="p-6 w-[80%] mx-auto">

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">

        {{-- Title --}}
        <h1 class="text-xl font-semibold mb-6 text-gray-700 border-b pb-2">
            {{ isset($salaryGrade) ? 'Edit Salary Grade' : 'Create Salary Grade' }}
        </h1>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-4 text-green-700 bg-green-100 border border-green-200 rounded px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ isset($salaryGrade) ? route('salary-grades.update', $salaryGrade->id) : route('salary-grades.store') }}"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @if (isset($salaryGrade)) @method('PUT') @endif

            {{-- Grade Name --}}
            <div class="col-span-1">
                <label for="grade_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Grade Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="grade_name" id="grade_name"
                       value="{{ old('grade_name', $salaryGrade->grade_name ?? '') }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm
                              focus:ring-2 focus:ring-green-200 focus:border-green-500 hover:border-green-400"
                       required>
                @error('grade_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm
                               focus:ring-2 focus:ring-green-200 focus:border-green-500 hover:border-green-400"
                        required>
                    <option value="1" {{ old('status', $salaryGrade->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $salaryGrade->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="col-span-1 md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full border border-gray-300 rounded px-4 py-2 text-sm
                                 focus:ring-2 focus:ring-green-200 focus:border-green-500 hover:border-green-400">{{ old('description', $salaryGrade->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Footer Buttons --}}
            <div class="col-span-1 md:col-span-2 flex justify-between items-center pt-4">
                {{-- Back Button --}}
                <a href="{{ route('salary-grades.index') }}"
                   class="inline-block bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
                    ← Back
                </a>

                {{-- Submit Button --}}
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded shadow transition-all">
                    {{ isset($salaryGrade) ? '✅ Update' : '✅ Create' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
