@extends('layouts.dashboard')

@section('content')
<div class="p-6 font-sans" x-data="shiftAssignModule()"> {{-- Alpine.js x-data initialization --}}
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 pb-4 border-b border-gray-200">Shift Assign</h1>

        {{-- Main Grid Layout (2 columns: left for filters & assignment, right for employee table) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Left Column: Filter Section AND Shift Assignment Details --}}
            <div class="md:col-span-1 space-y-6"> {{-- This column will now contain two sub-sections --}}

                {{-- Sub-section 1: Filter Employees --}}
                <div class="bg-gray-50 border border-gray-200 p-4 rounded-md space-y-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2 border-gray-200">Filter Employees</h2>

                    {{-- Select Unit --}}
                    <div>
                        <label for="filter_unit" class="block text-xs font-semibold text-gray-700 mb-1">Select Unit</label>
                        <select name="filter_unit" id="filter_unit" x-model="filters.unit_id" @change="fetchEmployees"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                            <option value="">All Units</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Department --}}
                    <div>
                        <label for="filter_department" class="block text-xs font-semibold text-gray-700 mb-1">Select Department</label>
                        <select name="filter_department" id="filter_department" x-model="filters.department_id" @change="fetchEmployees"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Division --}}
                    <div>
                        <label for="filter_division" class="block text-xs font-semibold text-gray-700 mb-1">Select Division</label>
                        <select name="filter_division" id="filter_division" x-model="filters.division_id" @change="fetchEmployees"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                            <option value="">All Divisions</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Designation --}}
                    <div>
                        <label for="filter_designation" class="block text-xs font-semibold text-gray-700 mb-1">Select Designation</label>
                        <select name="filter_designation" id="filter_designation" x-model="filters.designation_id" @change="fetchEmployees"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                            <option value="">All Designations</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Section --}}
                    <div>
                        <label for="filter_section" class="block text-xs font-semibold text-gray-700 mb-1">Select Section</label>
                        <select name="filter_section" id="filter_section" x-model="filters.section_id" @change="fetchEmployees"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                            <option value="">All Sections</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Line --}}
                    <div>
                        <label for="filter_line" class="block text-xs font-semibold text-gray-700 mb-1">Select Line</label>
                        <select name="filter_line" id="filter_line" x-model="filters.line_id" @change="fetchEmployees"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                            <option value="">All Lines</option>
                            @foreach($lines as $line) {{-- Assuming you have a 'lines' collection --}}
                                <option value="{{ $line->id }}">{{ $line->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Joining From --}}
                    <div>
                        <label for="joining_from" class="block text-xs font-semibold text-gray-700 mb-1">Joining From</label>
                        <input type="date" name="joining_from" id="joining_from" x-model="filters.joining_from"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                    </div>

                    {{-- Joining To --}}
                    <div>
                        <label for="joining_to" class="block text-xs font-semibold text-gray-700 mb-1">Joining To</label>
                        <input type="date" name="joining_to" id="joining_to" x-model="filters.joining_to"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                    </div>

                    <button type="button" @click="fetchEmployees"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-sm focus:outline-none border border-blue-700 shadow-sm">
                        Search Now
                    </button>
                </div>

                {{-- Sub-section 2: Shift Assignment Details (Moved here) --}}
                <form @submit.prevent="submitAssignment" class="bg-gray-50 border border-gray-200 p-4 rounded-md space-y-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2 border-gray-200">Shift Assignment Details</h2>

                    {{-- Select Type --}}
                    <div>
                        <label for="assign_type" class="block text-xs font-semibold text-gray-700 mb-1">Select Type</label>
                        <select name="assign_type" id="assign_type" x-model="assignmentData.type"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                            <option value="plan">Plan</option>
                            {{-- Add other types if necessary --}}
                        </select>
                    </div>

                    {{-- Select Plan/Rule --}}
                    <div>
                        <label for="assign_plan_rule" class="block text-xs font-semibold text-gray-700 mb-1">Select Plan/Rule</label>
                        <select name="assign_plan_rule" id="assign_plan_rule" x-model="assignmentData.shift_plan_id"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                            <option value="">Select One</option>
                            @foreach($shiftPlans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} ({{ \Carbon\Carbon::parse($plan->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($plan->end_time)->format('h:i A') }})</option>
                            @endforeach
                        </select>
                        <template x-if="errors.shift_plan_id">
                            <p class="text-red-500 text-xs mt-1" x-text="errors.shift_plan_id[0]"></p>
                        </template>
                    </div>
                    
                    {{-- Start Date --}}
                    <div>
                        <label for="assign_start_date" class="block text-xs font-semibold text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="assign_start_date" id="assign_start_date" x-model="assignmentData.start_date"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                        <template x-if="errors.start_date">
                            <p class="text-red-500 text-xs mt-1" x-text="errors.start_date[0]"></p>
                        </template>
                    </div>

                    {{-- End Date --}}
                    <div>
                        <label for="assign_end_date" class="block text-xs font-semibold text-gray-700 mb-1">End Date</label>
                        <input type="date" name="assign_end_date" id="assign_end_date" x-model="assignmentData.end_date"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                        <template x-if="errors.end_date">
                            <p class="text-red-500 text-xs mt-1" x-text="errors.end_date[0]"></p>
                        </template>
                    </div>

                    {{-- Remarks --}}
                    <div> {{-- Removed md:col-span-2 as it's now in a single column layout --}}
                        <label for="assign_remarks" class="block text-xs font-semibold text-gray-700 mb-1">Remarks</label>
                        <textarea name="assign_remarks" id="assign_remarks" rows="2" x-model="assignmentData.remarks"
                            class="w-full border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm"></textarea>
                        <template x-if="errors.remarks">
                            <p class="text-red-500 text-xs mt-1" x-text="errors.remarks[0]"></p>
                        </template>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end items-center"> {{-- Removed md:col-span-2 --}}
                         <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-4 py-2 rounded-sm focus:outline-none border border-blue-700 shadow-sm"
                            :disabled="loadingSubmit">
                            <span x-show="!loadingSubmit">Assign Shift</span>
                            <span x-show="loadingSubmit">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right Column: Employee Information & Search (Now takes 2/3 of the width) --}}
            <div class="md:col-span-2 space-y-4">
                {{-- Search Input for Employee Information --}}
                <div class="mb-4">
                    <label for="employee_search" class="sr-only">Type for search</label>
                    <input type="text" name="employee_search" id="employee_search" placeholder="Type for search"
                        x-model.debounce.300ms="filters.search" @input="fetchEmployees"
                        class="w-full border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none rounded-sm">
                </div>

                {{-- Employee Information Table --}}
                <div class="bg-gray-50 border border-gray-200 rounded-md overflow-hidden">
                    <h2 class="text-lg font-semibold text-gray-700 mb-0 p-3 border-b pb-2 border-gray-200">Employee Information</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider w-10">
                                        <input type="checkbox" @change="toggleSelectAll" :checked="isAllSelected()"
                                            class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out border-gray-300">
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Employee Code</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Designation</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Unit</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Department</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-if="loadingEmployees">
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-sm text-gray-500">Loading employees...</td>
                                    </tr>
                                </template>
                                <template x-if="!loadingEmployees && employees.length === 0">
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-sm text-gray-500">No employees found.</td>
                                    </tr>
                                </template>
                                <template x-for="employee in employees" :key="employee.id">
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <input type="checkbox" name="selected_employees[]" :value="employee.id" x-model="selectedEmployeeIds"
                                                class="form-checkbox h-4 w-4 text-blue-600">
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800" x-text="employee.employee_code"></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800" x-text="employee.name"></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800" x-text="employee.designation.name"></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800" x-text="employee.unit.name"></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800" x-text="employee.department.name"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination & Count Info --}}
                    <div class="flex justify-between items-center px-4 py-3 bg-gray-100 border-t border-gray-200 text-xs">
                        <div class="flex items-center space-x-1">
                            <button type="button" @click="goToPage(pagination.prev_page_url)" :disabled="!pagination.prev_page_url"
                                class="p-1 border border-gray-300 rounded-sm hover:bg-gray-200 disabled:opacity-50">←</button>
                            <span class="p-1 border border-blue-500 bg-blue-100 rounded-sm text-blue-700 font-bold" x-text="pagination.current_page"></span>
                            <button type="button" @click="goToPage(pagination.next_page_url)" :disabled="!pagination.next_page_url"
                                class="p-1 border border-gray-300 rounded-sm hover:bg-gray-200 disabled:opacity-50">→</button>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" @change="toggleSelectAll" :checked="isAllSelected()"
                                    class="form-checkbox h-4 w-4 text-blue-600">
                                <label for="select_all_bottom" class="ml-1 text-gray-700">Select All</label>
                            </div>
                            <span class="text-gray-700">Selected: <span class="font-bold" x-text="selectedEmployeeIds.length"></span></span>
                            <span class="text-gray-700">Found: <span class="font-bold" x-text="pagination.total"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function shiftAssignModule() {
        return {
            employees: [],
            selectedEmployeeIds: @json(old('selected_employees', [])), // Keep selected employees if validation fails
            pagination: {},
            loadingEmployees: false,
            loadingSubmit: false,
            filters: {
                unit_id: '',
                department_id: '',
                division_id: '',
                designation_id: '',
                section_id: '',
                line_id: '',
                joining_from: '',
                joining_to: '',
                search: '',
                page: 1,
            },
            assignmentData: {
                type: 'plan',
                shift_plan_id: '',
                start_date: '',
                end_date: '',
                remarks: '',
                _token: '{{ csrf_token() }}' // CSRF token for AJAX submission
            },
            errors: {}, // To store validation errors

            init() {
                this.fetchEmployees();
            },

            async fetchEmployees() {
                this.loadingEmployees = true;
                try {
                    const params = new URLSearchParams(this.filters).toString();
                    const response = await fetch(`/api/employees?${params}`); // Adjust API route
                    const data = await response.json();
                    this.employees = data.data;
                    this.pagination = {
                        current_page: data.current_page,
                        total: data.total,
                        prev_page_url: data.prev_page_url,
                        next_page_url: data.next_page_url,
                    };
                    // Clear selected employees if they are not in the current page
                    this.selectedEmployeeIds = this.selectedEmployeeIds.filter(id => 
                        this.employees.some(emp => emp.id === id)
                    );

                } catch (error) {
                    console.error('Error fetching employees:', error);
                    this.employees = [];
                    this.pagination = {};
                } finally {
                    this.loadingEmployees = false;
                }
            },

            goToPage(url) {
                if (url) {
                    const urlObj = new URL(url);
                    this.filters.page = urlObj.searchParams.get('page');
                    this.fetchEmployees();
                }
            },

            toggleSelectAll(event) {
                if (event.target.checked) {
                    this.selectedEmployeeIds = this.employees.map(emp => emp.id);
                } else {
                    this.selectedEmployeeIds = [];
                }
            },

            isAllSelected() {
                return this.employees.length > 0 && this.selectedEmployeeIds.length === this.employees.length;
            },

            async submitAssignment() {
                this.loadingSubmit = true;
                this.errors = {}; // Clear previous errors

                if (this.selectedEmployeeIds.length === 0) {
                    alert('Please select at least one employee.');
                    this.loadingSubmit = false;
                    return;
                }

                try {
                    const response = await fetch('/shift-assign', { // Match this route with your web.php route for store
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest', // Important for Laravel AJAX detection
                            'X-CSRF-TOKEN': this.assignmentData._token, // Ensure CSRF token is sent
                        },
                        body: JSON.stringify({
                            employee_ids: this.selectedEmployeeIds,
                            shift_plan_id: this.assignmentData.shift_plan_id,
                            start_date: this.assignmentData.start_date,
                            end_date: this.assignmentData.end_date,
                            remarks: this.assignmentData.remarks,
                        }),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        if (response.status === 422) { // Validation error
                            this.errors = data.errors;
                        } else {
                            alert('An unexpected error occurred: ' + (data.message || response.statusText));
                        }
                        return;
                    }

                    alert('Shifts assigned successfully!');
                    // Optionally reset form or redirect
                    this.resetForm();
                    // window.location.href = '/shift-assign'; // Redirect to index page
                } catch (error) {
                    console.error('Error submitting assignment:', error);
                    alert('Failed to assign shifts. Please try again.');
                } finally {
                    this.loadingSubmit = false;
                }
            },

            resetForm() {
                this.selectedEmployeeIds = [];
                this.assignmentData = {
                    type: 'plan',
                    shift_plan_id: '',
                    start_date: '',
                    end_date: '',
                    remarks: '',
                    _token: '{{ csrf_token() }}'
                };
                this.filters.page = 1; // Reset filters if needed or re-fetch current page
                this.fetchEmployees(); // Re-fetch employees to refresh table
                this.errors = {}; // Clear errors
            }
        }
    }
</script>
@endsection