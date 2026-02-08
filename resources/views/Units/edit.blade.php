@extends('layouts.dashboard') 

@section('content')
<div class="p-6 w-[60%] mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Edit Unit</h1>
        <a href="{{ route('units.index') }}"
           class="inline-block bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded shadow">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
        <form action="{{ route('units.update', $unit->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Include the form fields --}}
            @include('units.form', ['unit' => $unit])

            {{-- Submit button --}}
            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-6 py-2 rounded shadow">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
