@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Apply for Leave</h2>
    <form action="{{ route('leave-applications.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="employee_id" class="block font-medium mb-1">Employee <span class="text-red-600">*</span></label>
            <select name="employee_id" id="employee_id" class="w-full border px-3 py-2 rounded">
                <option value="">Select Employee</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="leave_type_id" class="block font-medium mb-1">Leave Type <span class="text-red-600">*</span></label>
            <select name="leave_type_id" id="leave_type_id" class="w-full border px-3 py-2 rounded">
                <option value="">Select Leave Type</option>
                @foreach ($leaveTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="start_date" class="block font-medium mb-1">Start Date <span class="text-red-600">*</span></label>
            <input type="date" name="start_date" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="end_date" class="block font-medium mb-1">End Date <span class="text-red-600">*</span></label>
            <input type="date" name="end_date" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="reason" class="block font-medium mb-1">Reason</label>
            <textarea name="reason" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('leave-applications.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit</button>
        </div>
    </form>
</div>
@endsection
