@extends('layouts.dashboard')

@section('content')
{{-- Your existing HTML content for the dashboard --}}
<div class="p-3 max-w-11xl mx-auto">


    {{-- Company/Unit Filters --}}
    <div class="mb-8 flex flex-wrap gap-2 justify-end">
    @php
        $companies = $companies ?? ['Unit A', 'Unit B', 'Unit C'];
    @endphp
    @foreach($companies as $company)
        <button class="company-filter bg-sky-600 hover:bg-sky-700 text-white px-5 py-1 rounded-md shadow-md text-sm font-semibold transition duration-200 ease-in-out transform hover:scale-120" data-unit="{{ $company }}">
            {{ $company }}
        </button>
    @endforeach
    <button class="company-filter bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-1 rounded-md shadow-md text-sm font-semibold transition duration-200 ease-in-out transform hover:scale-120 active" data-unit="All Units">
        All Units
    </button>
</div>


    {{-- Employee Data Overview --}}
    <h2 class="text-2xl font-regular text-gray-800 mb-4">Employee Overview</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-total-employees"></p>
                <i class="fas fa-users text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Total Employees</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-male-employees"></p>
                <i class="fas fa-male text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Male Employees</p>
        </div>
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-female-employees"></p>
                <i class="fas fa-female text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Female Employees</p>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-production-staff"></p>
                <i class="fas fa-hard-hat text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Production Staff</p>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-office-staff"></p>
                <i class="fas fa-briefcase text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Office Staff</p>
        </div>
    </div>

    {{-- Today's Attendance Data --}}
    <h2 class="text-2xl font-regular text-gray-800 mb-4">Today's Attendance</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-8">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-total-present"></p>
                <i class="fas fa-check-circle text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Total Present</p>
        </div>
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-total-absent"></p>
                <i class="fas fa-times-circle text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Total Absent</p>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-late-arrivals"></p>
                <i class="fas fa-clock text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Late Arrivals</p>
        </div>
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-on-leave"></p>
                <i class="fas fa-calendar-alt text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">On Leave Today</p>
        </div>
        <div class="bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-lg rounded-md p-5 flex flex-col justify-between h-28">
            <div class="flex items-center justify-between">
                <p class="text-3xl font-extrabold" id="stat-early-exits"></p>
                <i class="fas fa-sign-out-alt text-3xl opacity-50"></i>
            </div>
            <p class="text-sm font-medium mt-2">Early Exits</p>
        </div>
    </div>

    {{-- Detailed Data Section with Tabs --}}
    <div class="bg-white shadow-lg rounded-md p-6 mb-8">
        <div class="border-b border-gray-200 mb-4">
            <ul class="flex space-x-8 text-gray-600 text-sm font-semibold" id="detail-tabs">
                <li class="tab-item active border-b-4 border-blue-600 pb-3 cursor-pointer" data-tab="attendance-details">Attendance Details</li>
                <li class="tab-item pb-3 cursor-pointer hover:text-blue-600" data-tab="leave-requests">Leave Requests</li>
                <li class="tab-item pb-3 cursor-pointer hover:text-blue-600" data-tab="shift-schedules">Shift Schedules</li>
            </ul>
        </div>

        <div id="attendance-details" class="tab-content">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Today's Attendance Data (Department Wise)</h3>
            <div class="overflow-x-auto overflow-y-auto max-h-48 rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Department</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Present</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Male Present</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Female Present</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Total Absent</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="department-attendance-body">
                        {{-- Data will be populated by JavaScript based on unitData --}}
                    </tbody>
                </table>
            </div>
            <div id="attendance-pagination" class="mt-4 flex justify-end">
                {{-- Pagination links will be generated by JavaScript --}}
            </div>
        </div>

        <div id="leave-requests" class="tab-content hidden">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Pending Leave Requests</h3>
            <div class="overflow-x-auto overflow-y-auto max-h-48 rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Employee Name</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From Date</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To Date</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="leave-requests-body">
                        {{-- Dummy data for leave requests --}}
                        {{-- Data will be populated by JavaScript --}}
                    </tbody>
                </table>
            </div>
            <div id="leave-pagination" class="mt-4 flex justify-end">
                {{-- Pagination links will be generated by JavaScript --}}
            </div>
        </div>

        <div id="shift-schedules" class="tab-content hidden">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Upcoming Shift Schedules</h3>
            <div class="overflow-x-auto overflow-y-auto max-h-48 rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Shift Name</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employees Assigned</th>
                            <th scope="col" class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Department</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="shift-schedules-body">
                        {{-- Dummy data for shift schedules --}}
                        {{-- Data will be populated by JavaScript --}}
                    </tbody>
                </table>
            </div>
            <div id="shift-pagination" class="mt-4 flex justify-end">
                {{-- Pagination links will be generated by JavaScript --}}
            </div>
        </div>
    </div>

    {{-- Charts Placeholder --}}
    <h2 class="text-2xl regular text-gray-800 mb-4">Analytics & Reports</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white shadow-lg rounded-md p-6">
            <h3 class="text-xl font-regular text-gray-800 mb-4">Employee Distribution by Gender</h3>
            <div class="bg-gray-100 h-64 flex items-center justify-center rounded-lg text-gray-500">
                <p>Chart Placeholder (e.g., Pie Chart)</p>
            </div>
        </div>
        <div class="bg-white shadow-lg rounded-md p-6">
            <h3 class="text-xl font-regular text-gray-800 mb-4">Monthly Attendance Trend</h3>
            <div class="bg-gray-100 h-64 flex items-center justify-center rounded-lg text-gray-500">
                <p>Chart Placeholder (e.g., Line Chart)</p>
            </div>
        </div>
    </div>

    {{-- Quick Notifications / Alerts --}}
    <h2 class="text-2xl font-regular text-gray-800 mb-4">Important Notifications</h2>
    <div class="bg-white shadow-lg rounded-md p-6 mb-8">
        <ul class="space-y-3">
            <li class="flex items-center text-gray-700">
                <i class="fas fa-birthday-cake text-blue-500 mr-3"></i>
                <span>Upcoming Birthday: **Employee Name** on June 5th</span>
            </li>
            <li class="flex items-center text-gray-700">
                <i class="fas fa-bell text-yellow-500 mr-3"></i>
                <span>**2** documents expiring next month.</span>
            </li>
            <li class="flex items-center text-gray-700">
                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                <span>**1** employee has been marked absent for 3 consecutive days.</span>
            </li>
            <li class="flex items-center text-gray-700">
                <i class="fas fa-award text-green-500 mr-3"></i>
                <span>**Employee Name** completes 5 years of service on June 10th!</span>
            </li>
        </ul>
    </div>

</div>
@endsection

@push('scripts')
<script>
    console.log("Script block from dashboard.blade.php loaded!");

    // Initial data passed from Laravel (for first load, will be replaced by AJAX for attendance)
    const initialEmployeeStats = @json($employeeStats ?? []);
    const initialAttendanceStats = @json($attendanceStats ?? []);
    const initialDepartments = @json($departments ?? []);

    console.log("Initial Employee Stats (from Blade):", initialEmployeeStats);
    console.log("Initial Attendance Stats (from Blade):", initialAttendanceStats);
    console.log("Initial Departments (from Blade):", initialDepartments);

    // Global variables to keep track of current filter and page
    let currentUnit = 'All Units';
    let currentAttendancePage = 1; // Default page for attendance details
    let currentLeavePage = 1; // For Leave Requests
    let currentShiftPage = 1; // For Shift Schedules
    const itemsPerPage = 5; // Number of items per page for client-side pagination

    // Dummy data for client-side pagination (Leave Requests and Shift Schedules)
    const dummyLeaveRequests = [
        { employee_name: 'Jane Smith', leave_type: 'Casual Leave', from_date: '2025-06-01', to_date: '2025-06-03', status: 'Pending' },
        { employee_name: 'Robert Johnson', leave_type: 'Sick Leave', from_date: '2025-05-30', to_date: '2025-05-30', status: 'Pending' },
        { employee_name: 'Alice Brown', leave_type: 'Annual Leave', from_date: '2025-06-10', to_date: '2025-06-15', status: 'Approved' },
        { employee_name: 'Bob White', leave_type: 'Casual Leave', from_date: '2025-06-05', to_date: '2025-06-05', status: 'Pending' },
        { employee_name: 'Charlie Green', leave_type: 'Sick Leave', from_date: '2025-06-02', to_date: '2025-06-02', status: 'Approved' },
        { employee_name: 'Diana Prince', leave_type: 'Maternity Leave', from_date: '2025-07-01', to_date: '2025-09-30', status: 'Approved' },
        { employee_name: 'Eve Adams', leave_type: 'Paternity Leave', from_date: '2025-06-20', to_date: '2025-06-25', status: 'Pending' },
        { employee_name: 'Frank Miller', leave_type: 'Casual Leave', from_date: '2025-06-08', to_date: '2025-06-09', status: 'Pending' },
        { employee_name: 'Grace Taylor', leave_type: 'Sick Leave', from_date: '2025-06-12', to_date: '2025-06-12', status: 'Declined' },
        { employee_name: 'Harry Wilson', leave_type: 'Annual Leave', from_date: '2025-07-10', to_date: '2025-07-17', status: 'Pending' },
        { employee_name: 'Ivy Moore', leave_type: 'Casual Leave', from_date: '2025-06-18', to_date: '2025-06-19', status: 'Approved' },
        { employee_name: 'Jack King', leave_type: 'Sick Leave', from_date: '2025-06-25', to_date: '2025-06-25', status: 'Pending' },
    ];

    const dummyShiftSchedules = [
        { shift_name: 'Morning Shift', time: '06:00 AM - 02:00 PM', employees_assigned: 150, department: 'Cutting' },
        { shift_name: 'Evening Shift', time: '02:00 PM - 10:00 PM', employees_assigned: 120, department: 'Sewing' },
        { shift_name: 'Night Shift', time: '10:00 PM - 06:00 AM', employees_assigned: 90, department: 'Finishing' },
        { shift_name: 'Admin Shift', time: '09:00 AM - 05:00 PM', employees_assigned: 30, department: 'HR & Admin' },
        { shift_name: 'Quality Shift', time: '08:00 AM - 04:00 PM', employees_assigned: 40, department: 'Quality Control' },
        { shift_name: 'Maintenance Shift', time: '07:00 AM - 03:00 PM', employees_assigned: 20, department: 'Maintenance' },
        { shift_name: 'Weekend Morning', time: '07:00 AM - 03:00 PM', employees_assigned: 50, department: 'Sewing' },
        { shift_name: 'Weekend Evening', time: '03:00 PM - 11:00 PM', employees_assigned: 40, department: 'Cutting' },
        { shift_name: 'Special Project', time: '10:00 AM - 06:00 PM', employees_assigned: 25, department: 'R&D' },
        { shift_name: 'Training Shift', time: '09:00 AM - 01:00 PM', employees_assigned: 15, department: 'Training' },
    ];

    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOMContentLoaded event fired!");

        // Tab switching logic
        const tabItems = document.querySelectorAll('#detail-tabs .tab-item');
        const tabContents = document.querySelectorAll('.tab-content');

        tabItems.forEach(item => {
            item.addEventListener('click', function() {
                tabItems.forEach(tab => {
                    tab.classList.remove('active', 'border-b-4', 'border-blue-600', 'text-blue-800');
                    tab.classList.add('hover:text-blue-600');
                });
                tabContents.forEach(content => content.classList.add('hidden'));

                this.classList.add('active', 'border-b-4', 'border-blue-600', 'text-blue-800');
                this.classList.remove('hover:text-blue-600');
                const targetTabId = this.dataset.tab;
                document.getElementById(targetTabId).classList.remove('hidden');

                // When switching tabs, reset page to 1 and load data for that tab
                if (targetTabId === 'attendance-details') {
                    currentAttendancePage = 1;
                    fetchDashboardData(currentUnit, currentAttendancePage, 'attendance-details');
                } else if (targetTabId === 'leave-requests') {
                    currentLeavePage = 1;
                    renderLeaveRequestsTable(currentLeavePage);
                } else if (targetTabId === 'shift-schedules') {
                    currentShiftPage = 1;
                    renderShiftSchedulesTable(currentShiftPage);
                }
            });
        });

        // Function to fetch data from the backend via AJAX (for Attendance Details)
        async function fetchDashboardData(unit, page) {
            console.log(`Fetching data for Unit: ${unit}, Page: ${page} (Attendance Details)`);
            try {
                const response = await fetch(`/api/dashboard-data?unit=${unit}&page=${page}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                console.log("Received data (Attendance Details):", data);
                updateDashboardStats(data); // Updates employee and attendance overview stats
                renderDepartmentAttendanceTable(data.departments); // Render department table
                renderPagination(data.pagination, 'attendance-pagination', 'attendance-details', fetchDashboardData);
            } catch (error) {
                console.error("Error fetching dashboard data:", error);
                // Optionally show an error message on the dashboard
            }
        }

        // Function to update the dashboard overview stats
        function updateDashboardStats(data) {
            // Update Employee Stats
            document.getElementById('stat-total-employees').textContent = data.employeeStats.total || 0;
            document.getElementById('stat-male-employees').textContent = data.employeeStats.male || 0;
            document.getElementById('stat-female-employees').textContent = data.employeeStats.female || 0;
            document.getElementById('stat-production-staff').textContent = data.employeeStats.production_staff || 0;
            document.getElementById('stat-office-staff').textContent = data.employeeStats.office_staff || 0;

            // Update Attendance Stats
            document.getElementById('stat-total-present').textContent = data.attendanceStats.present || 0;
            document.getElementById('stat-total-absent').textContent = data.attendanceStats.absent || 0;
            document.getElementById('stat-late-arrivals').textContent = data.attendanceStats.late || 0;
            document.getElementById('stat-on-leave').textContent = data.attendanceStats.on_leave || 0;
            document.getElementById('stat-early-exits').textContent = data.attendanceStats.early_exit || 0;
        }

        // Function to render Department Wise Attendance Table
        function renderDepartmentAttendanceTable(departments) {
            const departmentTableBody = document.getElementById('department-attendance-body');
            departmentTableBody.innerHTML = ''; // Clear existing rows

            if (departments && departments.length > 0) {
                departments.forEach(dept => {
                    const row = `
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-3 whitespace-nowrap">${dept.name}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${dept.present || 0}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${dept.male || 0}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${dept.female || 0}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${dept.absent || 0}</td>
                        </tr>
                    `;
                    departmentTableBody.insertAdjacentHTML('beforeend', row);
                });
            } else {
                departmentTableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-2 px-3 text-center text-gray-500">No department attendance data available for this unit.</td>
                    </tr>
                `;
            }
        }

        // Function to render Leave Requests Table (Client-side pagination)
        function renderLeaveRequestsTable(page) {
            const leaveTableBody = document.getElementById('leave-requests-body');
            leaveTableBody.innerHTML = ''; // Clear existing rows

            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const paginatedData = dummyLeaveRequests.slice(startIndex, endIndex);

            if (paginatedData.length > 0) {
                paginatedData.forEach(request => {
                    const statusClass = request.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                       request.status === 'Approved' ? 'bg-green-100 text-green-800' :
                                       'bg-red-100 text-red-800';
                    const row = `
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-3 whitespace-nowrap">${request.employee_name}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${request.leave_type}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${request.from_date}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${request.to_date}</td>
                            <td class="py-2 px-3 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${request.status}</span></td>
                        </tr>
                    `;
                    leaveTableBody.insertAdjacentHTML('beforeend', row);
                });
            } else {
                leaveTableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-2 px-3 text-center text-gray-500">No pending leave requests.</td>
                    </tr>
                `;
            }

            // Render pagination for leave requests
            const totalPages = Math.ceil(dummyLeaveRequests.length / itemsPerPage);
            const paginationData = {
                current_page: page,
                last_page: totalPages,
                total: dummyLeaveRequests.length,
                per_page: itemsPerPage
            };
            renderPagination(paginationData, 'leave-pagination', 'leave-requests', renderLeaveRequestsTable);
        }

        // Function to render Shift Schedules Table (Client-side pagination)
        function renderShiftSchedulesTable(page) {
            const shiftTableBody = document.getElementById('shift-schedules-body');
            shiftTableBody.innerHTML = ''; // Clear existing rows

            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const paginatedData = dummyShiftSchedules.slice(startIndex, endIndex);

            if (paginatedData.length > 0) {
                paginatedData.forEach(schedule => {
                    const row = `
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-3 whitespace-nowrap">${schedule.shift_name}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${schedule.time}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${schedule.employees_assigned}</td>
                            <td class="py-2 px-3 whitespace-nowrap">${schedule.department}</td>
                        </tr>
                    `;
                    shiftTableBody.insertAdjacentHTML('beforeend', row);
                });
            } else {
                shiftTableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="py-2 px-3 text-center text-gray-500">No upcoming shift schedules.</td>
                    </tr>
                `;
            }

            // Render pagination for shift schedules
            const totalPages = Math.ceil(dummyShiftSchedules.length / itemsPerPage);
            const paginationData = {
                current_page: page,
                last_page: totalPages,
                total: dummyShiftSchedules.length,
                per_page: itemsPerPage
            };
            renderPagination(paginationData, 'shift-pagination', 'shift-schedules', renderShiftSchedulesTable);
        }


        // Function to render pagination links (Generic for both server-side and client-side)
        function renderPagination(pagination, containerId, tabName, fetchFunction) {
            const paginationContainer = document.getElementById(containerId);
            paginationContainer.innerHTML = '';

            if (pagination.last_page <= 1) {
                return; // No need for pagination if only one page
            }

            const ul = document.createElement('ul');
            ul.classList.add('flex', 'items-center', 'space-x-2');

            // Previous Button
            const prevLi = document.createElement('li');
            const prevButton = document.createElement('button');
            prevButton.textContent = 'Previous';
            prevButton.classList.add('px-4', 'py-2', 'rounded-lg', 'border', 'border-gray-300', 'hover:bg-gray-100');
            if (pagination.current_page === 1) {
                prevButton.disabled = true;
                prevButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                prevButton.addEventListener('click', () => {
                    if (tabName === 'attendance-details') {
                        currentAttendancePage--;
                    } else if (tabName === 'leave-requests') {
                        currentLeavePage--;
                    } else if (tabName === 'shift-schedules') {
                        currentShiftPage--;
                    }
                    fetchFunction(currentUnit, tabName === 'attendance-details' ? currentAttendancePage : (tabName === 'leave-requests' ? currentLeavePage : currentShiftPage));
                });
            }
            prevLi.appendChild(prevButton);
            ul.appendChild(prevLi);

            // Page Numbers
            for (let i = 1; i <= pagination.last_page; i++) {
                const pageLi = document.createElement('li');
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.classList.add('px-4', 'py-2', 'rounded-lg', 'border', 'border-gray-300', 'hover:bg-gray-100');
                if (i === pagination.current_page) {
                    pageButton.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                } else {
                    pageButton.addEventListener('click', () => {
                        if (tabName === 'attendance-details') {
                            currentAttendancePage = i;
                        } else if (tabName === 'leave-requests') {
                            currentLeavePage = i;
                        } else if (tabName === 'shift-schedules') {
                            currentShiftPage = i;
                        }
                        fetchFunction(currentUnit, i);
                    });
                }
                pageLi.appendChild(pageButton);
                ul.appendChild(pageLi);
            }

            // Next Button
            const nextLi = document.createElement('li');
            const nextButton = document.createElement('button');
            nextButton.textContent = 'Next';
            nextButton.classList.add('px-4', 'py-2', 'rounded-lg', 'border', 'border-gray-300', 'hover:bg-gray-100');
            if (pagination.current_page === pagination.last_page) {
                nextButton.disabled = true;
                nextButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                nextButton.addEventListener('click', () => {
                    if (tabName === 'attendance-details') {
                        currentAttendancePage++;
                    } else if (tabName === 'leave-requests') {
                        currentLeavePage++;
                    } else if (tabName === 'shift-schedules') {
                        currentShiftPage++;
                    }
                    fetchFunction(currentUnit, tabName === 'attendance-details' ? currentAttendancePage : (tabName === 'leave-requests' ? currentLeavePage : currentShiftPage));
                });
            }
            nextLi.appendChild(nextButton);
            ul.appendChild(nextLi);

            paginationContainer.appendChild(ul);
        }

        // Initial load: fetch data for 'All Units' and page 1 for all tabs
        fetchDashboardData(currentUnit, currentAttendancePage);
        renderLeaveRequestsTable(currentLeavePage);
        renderShiftSchedulesTable(currentShiftPage);


        // Add click event listeners to company filter buttons
        const companyFilterButtons = document.querySelectorAll('.company-filter');
        companyFilterButtons.forEach(button => {
            button.addEventListener('click', function() {
                companyFilterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.dataset.unit === 'All Units') {
                        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'text-white');
                        btn.classList.add('bg-gray-300', 'hover:bg-gray-400', 'text-gray-800');
                    } else {
                        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'text-white');
                        btn.classList.add('bg-sky-600', 'hover:bg-sky-700', 'text-white');
                    }
                });

                this.classList.add('active');
                if (this.dataset.unit === 'All Units') {
                    this.classList.remove('bg-gray-300', 'hover:bg-gray-400', 'text-gray-800');
                    this.classList.add('bg-blue-600', 'hover:bg-blue-700', 'text-white');
                } else {
                    this.classList.remove('bg-sky-600', 'hover:bg-sky-700', 'text-white');
                    this.classList.add('bg-blue-600', 'hover:bg-blue-700', 'text-white');
                }

                currentUnit = this.dataset.unit;
                currentAttendancePage = 1; // Reset to first page on unit change
                fetchDashboardData(currentUnit, currentAttendancePage);
                // For client-side tables, re-render with the current page (which is 1 after unit change)
                renderLeaveRequestsTable(currentLeavePage);
                renderShiftSchedulesTable(currentShiftPage);
            });
        });
    });
</script>
@endpush
