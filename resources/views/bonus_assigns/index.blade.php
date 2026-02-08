@extends('layouts.dashboard')

@section('content')
<div class="flex gap-4">

    <!-- Left: Employee List (40%) -->
    <div class="w-[40%] border p-3 shadow">
        <h3 class="text-2xl font-bold mb-2">Employees</h3>

        <!-- Search -->
        <form method="GET" class="mb-2">
            <input type="text" name="search" placeholder="Search by name or ID" value="{{ $search }}"
                   class="w-full p-1 border rounded" />
        </form>

        <!-- Employee List with Checkboxes -->
        <form method="GET">
            <div class="max-h-80 overflow-y-auto mb-2">
                <table class="w-full table-auto border-collapse text-sm">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="p-2 border text-left">Select</th>
                            <th class="p-2 border text-left">Employee Name</th>
                            <th class="p-2 border text-left">Employee Code</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-50">
                        @foreach($employees as $employee)
                            <tr class="border-b hover:bg-blue-100">
                                <td class="p-2 border">
                                    <input type="radio" name="selected_employee_id" value="{{ $employee->id }}"
                                           onchange="this.form.submit()" {{ $selectedEmployeeId == $employee->id ? 'checked' : '' }}>
                                </td>
                                <td class="p-2 border">{{ $employee->name }}</td>
                                <td class="p-2 border">{{ $employee->employee_code }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

         </form>

        <!-- Pagination -->
        <div class="mt-2">
            {{ $employees->appends(['search' => $search])->links() }}
        </div>
    </div>

    <!-- Right: Assigned Policies (60%) -->
    <div class="w-[60%] border p-3 shadow">
        <h3 class="text-2xl font-bold mb-6">Assigned Policies</h3>

        @if($assignedPolicies && $assignedPolicies->count() > 0)
            <table class="w-full table-auto border-collapse text-sm">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="p-2 border text-left">Employee Name</th>
                        <th class="p-2 border text-left">Employee Code</th>
                        <th class="p-2 border text-left">Status</th>
                        <th class="p-2 border text-left">Policy Master</th>
                        <th class="p-2 border text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50">
                    @foreach($assignedPolicies as $assigned)
                        <tr class="border-b hover:bg-blue-100">
                            <td class="p-2 border">{{ $assigned->employee->name }}</td>
                            <td class="p-2 border">{{ $assigned->employee->employee_code }}</td>
                            <td class="p-2 border">{{ $assigned->employee->status ? 'Active' : 'Inactive' }}</td>
                            <td class="p-2 border">{{ $assigned->policyMaster->name }}</td>
                            <td class="p-2 border">
                                <a href="#" class="text-blue-500 hover:underline">Edit</a> |
                                <a href="#" class="text-red-500 hover:underline">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-2">
                {{ $assignedPolicies->links() }}
            </div>
        @else
            <p>Select an employee to view assigned policies.</p>
        @endif

        <!-- Assign Bonus Button -->
        <div class="mt-6 text-right">
            <a href="{{ route('bonus-assigns.create') }}" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 text-sm">
                Add New
            </a>
        </div>
    </div>

</div>
@endsection
