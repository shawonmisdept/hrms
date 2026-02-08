@extends('layouts.dashboard')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-6xl mx-auto">
    <h2 class="text-lg font-semibold mb-4">Edit Leave Type</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('leave-types.update', $leaveType->id) }}">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ $leaveType->name }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Max Days <span class="text-red-500">*</span></label>
            <input type="number" name="max_days" class="w-full border p-2 rounded" value="{{ $leaveType->max_days }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="3">{{ $leaveType->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="1" {{ $leaveType->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$leaveType->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('leave-types.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded">Back</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </div>
    </form>
</div>
@endsection
