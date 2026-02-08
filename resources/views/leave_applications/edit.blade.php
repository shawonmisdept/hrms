@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Edit Leave Application</h2>
    <form action="{{ route('leave-applications.update', $leaveApplication->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="employee_id" class="block font-medium mb-1">Employee</label>
            <select name="employee_id" class="w-full border px-3 py-2 rounded" disabled>
                <option value="{{ $leaveApplication->employee_id }}">
                    {{ $leaveApplication->employee->name ?? 'N/A' }}
                </option>
            </select>
        </div>

        <div class="mb-4">
            <label for="leave_type_id" class="block font-medium mb-1">Leave Type</label>
            <select name="leave_type_id" class="w-full border px-3 py-2 rounded">
                @foreach ($leaveTypes as $type)
                    <option value="{{ $type->id }}" {{ $type->id == $leaveApplication->leave_type_id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="start_date" class="block font-medium mb-1">Start Date</label>
            <input type="date" name="start_date" value="{{ $leaveApplication->start_date }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label for="end_date" class="block font-medium mb-1">End Date</label>
            <input type="date" name="end_date" value="{{ $leaveApplication->end_date }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label for="reason" class="block font-medium mb-1">Reason</label>
            <textarea name="reason" rows="3" class="w-full border px-3 py-2 rounded">{{ $leaveApplication->reason }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('leave-applications.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
