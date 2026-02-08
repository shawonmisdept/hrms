@extends('layouts.dashboard')

@section('content')
<div class="flex gap-6 p-6">
    <!-- Left: Employee List -->
    <div class="w-1/2 border p-4 shadow">
        <!-- Employee Title on the Left and Search Box on the Right -->
        <div class="flex justify-between mb-4">
            <!-- Employee Title -->
            <h3 class="text-2xl font-bold">Employees</h3>

            <!-- Search Box -->
            <input type="text" id="searchEmployee" placeholder="Search Employee" class="w-1/2 p-1 border rounded">
        </div>

        <form method="POST" action="{{ route('bonus-assigns.store') }}">
            @csrf
            <div class="max-h-80 overflow-y-auto">
                <table class="w-full table-auto border-collapse text-sm">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="p-2 border text-left"><input type="checkbox" id="selectAll"></th>
                            <th class="p-2 border text-left">#</th>
                            <th class="p-2 border text-left">ID</th>
                            <th class="p-2 border text-left">Name</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-50" id="employeeTable">
                        @foreach($employees as $index => $employee)
                            <tr class="border-b hover:bg-blue-100">
                                <td class="p-2 border">
                                    <input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}">
                                </td>
                                <td class="p-2 border">{{ $index + 1 }}</td>
                                <td class="p-2 border">{{ $employee->employee_code }}</td>
                                <td class="p-2 border">{{ $employee->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-2">
                {{ $employees->links() }}
            </div>
    </div>

    <!-- Right: Policy Master List -->
    <div class="w-1/2 border p-4 shadow">
        <h3 class="text-xl font-bold mb-4">Policy Masters</h3>
        <div class="max-h-80 overflow-y-auto">
            <table class="w-full table-auto border-collapse text-sm">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="p-2 border text-left">Select</th>
                        <th class="p-2 border text-left">Policy Name</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50">
                    @foreach($policies as $policy)
                        <tr class="border-b hover:bg-blue-100">
                            <td class="p-2 border">
                                <input type="radio" name="policy_id" value="{{ $policy->id }}" required>
                            </td>
                            <td class="p-2 border">{{ $policy->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                Assign
            </button>
        </div>
    </div>
    </form>
</div>

@if(session('success'))
    <div class="p-4 bg-green-100 text-green-800 mt-4 mx-6 rounded">
        {{ session('success') }}
    </div>
@endif

<script>
    document.getElementById('selectAll').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('input[name="employee_ids[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    document.getElementById('searchEmployee').addEventListener('input', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#employeeTable tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>
@endsection
