@extends('layouts.dashboard') {{-- আপনার main dashboard layout file --}}

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="bg-blue-600 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h4 class="text-xl font-semibold">Employee Details: {{ $employee->first_name }} {{ $employee->last_name }}</h4>
            <div class="flex space-x-2">
                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export
                </a>
                <a href="{{ route('employees.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    View All
                </a>
            </div>
        </div>
        <div class="p-4">
            {{-- Personal and Official Information Section (Simplified) --}}
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                <div class="border-b pb-3 mb-3">
                    <h5 class="text-lg font-medium text-gray-800">Employee Overview</h5>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    {{-- Left: Photo --}}
                    <div class="flex flex-col items-center justify-center p-2">
                        <div class="mb-3">
                            {{-- Image made square by changing rounded-full to rounded-lg --}}
                            <img src="{{ $employee->emp_photo ? asset('storage/employee_photos/' . $employee->emp_photo) : asset('storage/employee_photos/no-photo.png') }}" alt="Employee Photo" class="w-40 h-40 object-cover border-2 border-gray-300 bg-gray-200 rounded-lg">
                        </div>
                    </div>

                    {{-- Middle: Personal Details --}}
                    <div class="space-y-3 p-2">
                        {{-- Each item is now on a single line --}}
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Employee ID:</p>
                            <p class="text-base text-gray-900">{{ $employee->employee_id ?? 'N/A' }}</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Full Name:</p>
                            <p class="text-base text-gray-900">{{ $employee->salutation }} {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Mobile:</p>
                            <p class="text-base text-gray-900">{{ $employee->mobile ?? 'N/A' }}</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Gender:</p>
                            <p class="text-base text-gray-900">{{ $employee->gender ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- Right: Official Details --}}
                    <div class="space-y-3 p-2">
                        {{-- Each item is now on a single line --}}
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Employee Code:</p>
                            <p class="text-base text-gray-900">{{ $employee->employee_code ?? 'N/A' }}</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Unit:</p>
                            <p class="text-base text-gray-900">{{ $employee->unit->name ?? 'N/A' }}</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Designation:</p>
                            <p class="text-base text-gray-900">{{ $employee->designation->name ?? 'N/A' }}</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Department:</p>
                            <p class="text-base text-gray-900">{{ $employee->department->name ?? 'N/A' }}</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-sm font-medium text-gray-700 mr-1">Join Date:</p>
                            <p class="text-base text-gray-900">{{ $employee->join_date ? $employee->join_date->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-x-3 mt-5">
                <a href="{{ route('employees.edit', $employee->id) }}" class="inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Edit Employee
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
