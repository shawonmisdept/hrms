@extends('layouts.dashboard')

@section('content')
<div class="p-3 max-w-11xl mx-auto">
    {{-- মূল ফ্রেম যা ফিল্টার, সার্চ এবং টেবিলকে ঘিরে রাখবে --}}
    <div class="bg-white shadow-md rounded-lg">
        {{-- Modified header div, now inside the main frame --}}
        <div class="bg-gray-200 p-4 rounded-t-lg flex justify-between items-center"> {{-- Removed my-6 --}}
            <h3 class="text-xl font-semibold text-gray-800 flex items-center">All Employees</h3>
            <button type="button"
                    class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    onclick="window.location='{{ url('/employees/create') }}'">
                Add New
            </button>
        </div>

        {{-- Content below the header, now with its own padding --}}
        <div class="p-6">
            <form id="employeeFilterForm" method="GET" action="{{ url('/employees') }}">
                {{-- ফিল্টার ড্রপডাউনগুলো --}}
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                    <div>
                        <label for="unitFilter" class="block text-xs font-medium text-gray-700">Unit</label>
                        <select id="unitFilter" name="unit" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ request('unit') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="departmentFilter" class="block text-xs font-medium text-gray-700">Department</label>
                        <select id="departmentFilter" name="department" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="designationFilter" class="block text-xs font-medium text-gray-700">Designation</label>
                        <select id="designationFilter" name="designation" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}" {{ request('designation') == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sectionFilter" class="block text-xs font-medium text-gray-700">Section</label>
                        <select id="sectionFilter" name="section" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ request('section') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="divisionFilter" class="block text-xs font-medium text-gray-700">Division</label>
                        <select id="divisionFilter" name="division" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ request('division') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="lineFilter" class="block text-xs font-medium text-gray-700">Line</label>
                        <select id="lineFilter" name="line" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($lines as $line)
                                <option value="{{ $line->id }}" {{ request('line') == $line->id ? 'selected' : '' }}>{{ $line->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="genderFilter" class="block text-xs font-medium text-gray-700">Gender</label>
                        <select id="genderFilter" name="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="staffCategoryFilter" class="block text-xs font-medium text-gray-700">Staff Category</label>
                        <select id="staffCategoryFilter" name="staff_category" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($staffCategories as $category)
                                <option value="{{ $category->id }}" {{ request('staff_category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="salaryGradeFilter" class="block text-xs font-medium text-gray-700">Salary Grades</label>
                        <select id="salaryGradeFilter" name="salary_grade" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($salaryGrades as $grade)
                                <option value="{{ $grade->id }}" {{ request('salary_grade') == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="shiftPlanFilter" class="block text-xs font-medium text-gray-700">Shift Plans</label>
                        <select id="shiftPlanFilter" name="shift_plan" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            @foreach($shiftPlans as $shift)
                                <option value="{{ $shift->id }}" {{ request('shift_plan') == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="statusFilter" class="block text-xs font-medium text-gray-700">Status</label>
                        <select id="statusFilter" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md">
                            <option value="">All</option>
                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="Blocked" {{ request('status') == 'Blocked' ? 'selected' : '' }}>Blocked</option>
                            <option value="Suspended" {{ request('status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                </div>

                {{-- Per-page এবং Search সেকশন, সার্চ ডান পাশে --}}
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <label for="perPage" class="text-sm font-medium text-gray-700">Show per page:</label>
                        <select id="perPage" name="per_page" class="border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    {{-- সার্চ ইনপুট ডান পাশে --}}
                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        value="{{ request('search') }}"
                        placeholder="Search by name, code, department..."
                        class="block w-1/3 border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        autocomplete="off"
                    />
                </div>

                <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">#</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Photo</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Emp Code</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Full Name</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Mobile</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Department</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Designation</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Join Date</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Created</th>
                                <th scope="col" class="relative py-2 pl-3 pr-4 sm:pr-6 text-sm font-semibold text-gray-900">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($employees as $employee)
                                <tr>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-500">{{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}</td>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-500">
                                        <img src="{{ $employee->emp_photo ? asset('storage/employee_photos/' . $employee->emp_photo) : asset('images/default_profile.png') }}" alt="Profile Photo" class="w-12 h-12 rounded-md object-cover">
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-500">{{ $employee->employee_code }}</td>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-900">{{ $employee->salutation }} {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</td>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-500">{{ $employee->mobile }}</td>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-500">{{ $employee->department->name ?? 'N/A' }}</td>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-500">{{ $employee->designation->name ?? 'N/A' }}</td>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-500">{{ \Carbon\Carbon::parse($employee->join_date)->format('Y-m-d') }}</td>
                                    <td class="px-3 py-1 whitespace-nowrap">
                                    @switch($employee->status)
                                        @case('Active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                            @break
                                        @case('Pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                            @break
                                        @case('Inactive')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                            @break
                                        @case('Blocked')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-300 text-gray-800">
                                                Blocked
                                            </span>
                                            @break
                                        @case('Suspended')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Suspended
                                            </span>
                                            @break
                                        @default
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $employee->status ?? 'N/A' }}
                                            </span>
                                    @endswitch
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-1 text-xs text-gray-500">{{ \Carbon\Carbon::parse($employee->created_at)->format('Y-m-d') }}</td>
                                    <td class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-xs font-medium sm:pr-6">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ url('/employees/' . $employee->id) }}" class="text-indigo-600 hover:text-indigo-900" title="View">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                                    <path fill-rule="evenodd" d="M.661 10c1.765-4.484 6.002-8 9.339-8s7.574 3.516 9.339 8c-1.765 4.484-6.002 8-9.339 8s-7.574-3.516-9.339-8zM10 16a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a href="{{ url('/employees/' . $employee->id . '/edit') }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828L8.28 15.707 5.172 12.599l8.414-8.414zM4.096 15.904L2.89 17.11a1 1 0 001.414 1.414l1.206-1.206-1.414-1.414z" />
                                                </svg>
                                            </a>
                                            <form action="{{ url('/employees/' . $employee->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete" onclick="return confirm('Are you sure you want to delete this employee?');">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm1 3a1 1 0 100 2h4a1 1 0 100-2H8z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-3 py-1 text-xs text-gray-500 text-center">No employees found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $employees->links() }}
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto submit form on filter change
    document.querySelectorAll('#employeeFilterForm select').forEach(select => {
        select.addEventListener('change', () => {
            document.getElementById('employeeFilterForm').submit();
        });
    });

    // Debounce function to limit search input submissions
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Auto submit form on search input after debounce (2000ms = 2 seconds)
    document.getElementById('searchInput').addEventListener('input', debounce(function() {
        document.getElementById('employeeFilterForm').submit();
    }, 2000)); // 2000ms = 2 seconds

    // Auto submit form when search input loses focus (clicks outside)
    document.getElementById('searchInput').addEventListener('blur', function() {
        document.getElementById('employeeFilterForm').submit();
    });
</script>
@endsection
