<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    {{-- REPLACE the old asset() calls with @vite directive --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome for Icons (if not included in app.css or via Vite) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    @stack('styles')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div id="app" class="flex h-screen">
        {{-- Sidebar or Navigation goes here --}}
        <aside class="w-50 bg-white shadow-md h-screen overflow-y-auto p-4 flex-shrink-0" 
        x-data="{
            // Top-level menus
            employeesMenu: false,
            shiftMenu: false,
            attendanceMenu: false,
            leaveMenu: false,
            paymentsMenu: false,
            trainingMenu: false,
            separationMenu: false,
            settlementMenu: false,
            requisitionMenu: false,
            skillMatrixMenu: false,
            vehicleMenu: false,
            reportsMenu: false, // Reports itself has sub-menus
            settingsMenu: false, // Settings itself has sub-menus

            // Sub-menus under Employees
            basicOrientationMenu: false,
            appraisalMenu: false,

            // Sub-menus under Attendance
            overtimeMenu: false,
            noWorkNoPayMenu: false,
            continuousAbsentMenu: false,

            // Sub-menus under Payments
            salaryMenu: false,
            bonusMenu: false,
            loanMenu: false,
            incomeTaxMenu: false,
            providentFundMenu: false,
            paymentsLeaveMenu: false, // Renamed to avoid conflict with top-level 'leaveMenu'

            // Sub-menus under Skill Matrix
            skillMatrixAssignMenu: false, // Assign is now a sub-menu of Skill Matrix
            
            // Sub-menus under Reports
            reportsEmployeeMenu: false,
            reportsAttendanceMenu: false,
            reportsLeaveMenu: false,
            reportsPaymentsMenu: false,

            // Sub-menus under Settings
            tafshilMenu: false,
            systemVariableMenu: false,
            systemVariableDepartmentMenu: false, // Sub-menu of System Variable

            searchTerm: '', 
            
            // Function to filter menu items
            filterMenu() {
                const keyword = this.searchTerm.toLowerCase();
                const allLinks = this.$el.querySelectorAll('a.menu-item-link');
                const allButtons = this.$el.querySelectorAll('button.menu-item-button');

                // Reset display for all items
                allLinks.forEach(link => link.style.display = 'block');
                allButtons.forEach(button => button.style.display = 'flex');

                // Hide items that do not match the search term
                allLinks.forEach(link => {
                    if (!link.textContent.toLowerCase().includes(keyword)) {
                        link.style.display = 'none';
                    }
                });

                // Iterate buttons from innermost to outermost
                // This ensures child visibility influences parent visibility
                const reversedButtons = Array.from(allButtons).reverse(); 
                reversedButtons.forEach(button => {
                    const buttonText = button.querySelector('span').textContent.toLowerCase();
                    const relatedDiv = button.nextElementSibling; // The div containing sub-items
                    
                    let hasVisibleChildren = false;
                    if (relatedDiv && relatedDiv.hasAttribute('x-show')) {
                        // Check if any direct child links are visible
                        Array.from(relatedDiv.querySelectorAll('a.menu-item-link')).forEach(childLink => {
                            if (childLink.style.display !== 'none') {
                                hasVisibleChildren = true;
                            }
                        });
                        // Check if any direct child buttons are visible
                        Array.from(relatedDiv.querySelectorAll('button.menu-item-button')).forEach(childButton => {
                             if (childButton.style.display !== 'none') {
                                hasVisibleChildren = true;
                            }
                        });
                    }

                    if (buttonText.includes(keyword) || hasVisibleChildren) {
                        button.style.display = 'flex'; // Ensure button is visible
                        // Open the menu if the button itself matches or has visible children
                        const propName = button.getAttribute('@click').split('=')[1].replace('!', '').replace(')', '').trim();
                        if (this[propName] !== undefined) {
                            this[propName] = true;
                        }
                    } else {
                        button.style.display = 'none'; // Hide button if no match and no visible children
                    }
                });

                // Ensure all parents of visible items are open and visible
                allLinks.forEach(link => {
                    if (link.style.display !== 'none') {
                        let parentDiv = link.closest('div[x-show]');
                        while (parentDiv) {
                            const previousSibling = parentDiv.previousElementSibling;
                            if (previousSibling && previousSibling.tagName === 'BUTTON' && previousSibling.hasAttribute('@click')) {
                                const propName = previousSibling.getAttribute('@click').split('=')[1].replace('!', '').replace(')', '').trim();
                                if (this[propName] !== undefined) {
                                    this[propName] = true; // Open the parent menu
                                    previousSibling.style.display = 'flex'; // Ensure parent button is visible
                                }
                            }
                            parentDiv = parentDiv.parentElement.closest('div[x-show]');
                        }
                    }
                });
            }
        }">

        <div class="mb-4">
            <input type="text" 
                   x-model="searchTerm" 
                   @input="filterMenu()" 
                   placeholder="Search menu..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <nav class="space-y-1 text-gray-700 font-semibold text-sm">

            <a href="{{ route('dashboard') }}" class="menu-item-link flex items-center px-3 py-2 rounded hover:bg-blue-100 transition-colors duration-200">
                🏠 <span class="ml-2">Dashboard</span>
            </a>
            <button @click="employeesMenu = !employeesMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>👥 Employees</span>
                <svg :class="{'rotate-180': employeesMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="employeesMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="{{ route('employees.create') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Add New</a>
                <a href="{{ route('employees.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">View All</a>

                <button @click="basicOrientationMenu = !basicOrientationMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Basic Orientation</span>
                    <svg :class="{'rotate-180': basicOrientationMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="basicOrientationMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Assign</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">List</a>
                </div>

                <button @click="appraisalMenu = !appraisalMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Appraisal</span>
                    <svg :class="{'rotate-180': appraisalMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="appraisalMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Heads</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Ratings</a>
                </div>

                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">DA Claims</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Bank Info</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Supervisor</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="shiftMenu = !shiftMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>⏰ Shift</span>
                <svg :class="{'rotate-180': shiftMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="shiftMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="{{ route('shift_plans.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Shift Plans</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Shift Rules</a>
                <a href="{{ route('shift_assigns.create') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Shift Assign</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Manual</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="attendanceMenu = !attendanceMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>📅 Attendance</span>
                <svg :class="{'rotate-180': attendanceMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="attendanceMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Rule</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Policy</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Upload Data</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Process</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Manual</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Out of Office</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Allow Late</a>

                <button @click="overtimeMenu = !overtimeMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Over Time</span>
                    <svg :class="{'rotate-180': overtimeMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="overtimeMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Slabs</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Rounding</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Summary Sheet</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Eligibility</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">W/H Eligibility</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Eligibility User Configuration</a>
                </div>

                <button @click="noWorkNoPayMenu = !noWorkNoPayMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>No Work No Pay</span>
                    <svg :class="{'rotate-180': noWorkNoPayMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="noWorkNoPayMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Assign</a>
                </div>

                <button @click="continuousAbsentMenu = !continuousAbsentMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Continuous Absent</span>
                    <svg :class="{'rotate-180': continuousAbsentMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="continuousAbsentMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Notice</a>
                </div>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="leaveMenu = !leaveMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>🌴 Leave</span>
                <svg :class="{'rotate-180': leaveMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="leaveMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="{{ route('leave-types.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Leave Policies</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Leave Rules</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Maternity Rules</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Opening Balance</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Maternity Transaction</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Leave Transaction</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Allocation Process</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Leave Entry Bulk</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="paymentsMenu = !paymentsMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>💰 Payments</span>
                <svg :class="{'rotate-180': paymentsMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="paymentsMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">

                <button @click="salaryMenu = !salaryMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Salary</span>
                    <svg :class="{'rotate-180': salaryMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="salaryMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="{{ route('salary_heads.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Salary Head</a>
                    <a href="{{ route('salary-grades.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Salary Grade</a>
                    <a href="{{ route('salary-grade-details.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Salary Grade Details</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Employee Salary</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Upload Salary</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Salary Process</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Salary Close</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Increment Rule</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Increment Bulk</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Increment Upload</a>
                </div>

                <button @click="bonusMenu = !bonusMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Bonus</span>
                    <svg :class="{'rotate-180': bonusMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="bonusMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="{{ route('policy-masters.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Policy Master</a>
                    <a href="{{ route('policy-details.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Policy Details</a>
                    <a href="{{ route('bonus-assigns.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Assign</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Transaction</a>
                </div>

                <button @click="loanMenu = !loanMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Loan</span>
                    <svg :class="{'rotate-180': loanMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="loanMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Configuration</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Interest Rate</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Loan Assign</a>
                </div>

                <button @click="incomeTaxMenu = !incomeTaxMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Income Tax</span>
                    <svg :class="{'rotate-180': incomeTaxMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="incomeTaxMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Tax Assign</a>
                </div>

                <button @click="providentFundMenu = !providentFundMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Provident Fund</span>
                    <svg :class="{'rotate-180': providentFundMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="providentFundMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Configuration</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Assign</a>
                </div>

                <button @click="paymentsLeaveMenu = !paymentsLeaveMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Leave Payments</span>
                    <svg :class="{'rotate-180': paymentsLeaveMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="paymentsLeaveMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">E.L Payment</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Maternity Leave</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Maternity Payment</a>
                </div>

                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Special Day</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="trainingMenu = !trainingMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>📚 Training</span>
                <svg :class="{'rotate-180': trainingMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="trainingMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Committee</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Trainings</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Employee Training</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="separationMenu = !separationMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>🚶‍♀️ Separation</span>
                <svg :class="{'rotate-180': separationMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="separationMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Types</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Configuration</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Notice</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Process Notice</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="settlementMenu = !settlementMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>💸 Settlement</span>
                <svg :class="{'rotate-180': settlementMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="settlementMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Pending List</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Checking List</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Audit List</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Finance List</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Final Settle</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="requisitionMenu = !requisitionMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>📝 Requisition</span>
                <svg :class="{'rotate-180': requisitionMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="requisitionMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">View All</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">New Requisition</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="skillMatrixMenu = !skillMatrixMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>🧠 Skill Matrix</span>
                <svg :class="{'rotate-180': skillMatrixMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="skillMatrixMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Assign</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Bulk Assign</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Batch</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="vehicleMenu = !vehicleMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>🚗 Vehicle</span>
                <svg :class="{'rotate-180': vehicleMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="vehicleMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Routes</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Types</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Vehicles</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Vehicle Assign</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Employee Vehicle</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Employee List</a>
                <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Daily Vehicles</a>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="reportsMenu = !reportsMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>📊 Reports</span>
                <svg :class="{'rotate-180': reportsMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="reportsMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <button @click="reportsEmployeeMenu = !reportsEmployeeMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Employee</span>
                    <svg :class="{'rotate-180': reportsEmployeeMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="reportsEmployeeMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Employee Report</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Gender Wise</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Promotion</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Separated</a>
                </div>

                <button @click="reportsAttendanceMenu = !reportsAttendanceMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Attendance</span>
                    <svg :class="{'rotate-180': reportsAttendanceMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="reportsAttendanceMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Attendance Report</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Attendance Summary</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Overtime Eligibility</a>
                </div>

                <button @click="reportsLeaveMenu = !reportsLeaveMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Leave</span>
                    <svg :class="{'rotate-180': reportsLeaveMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="reportsLeaveMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Leave Report</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Maternity Leave</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Leave Summary</a>
                </div>

                <button @click="reportsPaymentsMenu = !reportsPaymentsMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Payments</span>
                    <svg :class="{'rotate-180': reportsPaymentsMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="reportsPaymentsMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Payment Report</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Bonus Statements</a>
                </div>
            </div>

            <div class="my-2 border-t border-gray-200"></div>

            <button @click="settingsMenu = !settingsMenu" 
                    class="menu-item-button flex justify-between items-center w-full px-3 py-2 hover:bg-blue-100 rounded focus:outline-none transition-colors duration-200">
                <span>⚙️ Settings</span>
                <svg :class="{'rotate-180': settingsMenu}" class="w-4 h-4 transition-transform duration-200" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="settingsMenu" x-collapse class="pl-5 mt-1 space-y-1 text-gray-600 text-xs">
                <button @click="tafshilMenu = !tafshilMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>Tafshil</span>
                    <svg :class="{'rotate-180': tafshilMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="tafshilMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Tafshil</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Tafshil Grade</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Tafshil Grade Details</a>
                </div>

                <button @click="systemVariableMenu = !systemVariableMenu" 
                        class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                    <span>System Variable</span>
                    <svg :class="{'rotate-180': systemVariableMenu}" class="w-4 h-4 transition-transform duration-200" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="systemVariableMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                    <a href="{{ route('units.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Units</a>
                    <a href="{{ route('divisions.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Divisions</a>
                    <a href="{{ route('sections.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Sections</a>
                    
                    <button @click="systemVariableDepartmentMenu = !systemVariableDepartmentMenu" 
                            class="menu-item-button flex justify-between items-center w-full px-2 py-1 rounded hover:bg-blue-50 focus:outline-none transition-colors duration-150">
                        <span>Department</span>
                        <svg :class="{'rotate-180': systemVariableDepartmentMenu}" class="w-4 h-4 transition-transform duration-200" 
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                             stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </button>
                    <div x-show="systemVariableDepartmentMenu" x-collapse class="pl-5 space-y-1 text-gray-500 text-xs">
                        <a href="{{ route('departments.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Departments</a>
                        <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Strength</a>
                    </div>

                    <a href="{{ route('designations.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Designations</a>
                    <a href="{{ route('staff_categories.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Staff Categories</a>
                    <a href="" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Nature Of Job</a>
                    <a href="{{ route('countries.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Countries</a>
                    <a href="{{ route('districts.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">District</a>
                    <a href="{{ route('upazilas.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Upzaila</a>
                    <a href="{{ route('banks.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Banks</a>
                    <a href="{{ route('bank_branches.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Bank Branch</a>
                    <a href="{{ route('insurances.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Insurance</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Cost Centers</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Position</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Currency Rule</a>
                    <a href="{{ route('lines.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Line</a>
                    <a href="#" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Designation Group</a>
                    <a href="{{ route('education.index') }}" class="menu-item-link block px-2 py-1 rounded hover:bg-blue-50 transition-colors duration-150">Educational</a>
                </div>
            </div>
        </nav>
    </aside>

        <div class="flex-1 overflow-x-hidden overflow-y-auto">
            {{-- Header or Navbar inside the main content area --}}
            <header class="w-full bg-white shadow py-4 px-6 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                
                {{-- Live Clock --}}
                <div class="flex items-center space-x-6">
                    <div id="live-clock" class="text-sm text-gray-600 font-medium">
                        <span id="date"></span> | <span id="time"></span>
                    </div>

                    {{-- User Dropdown --}}
                    <div class="relative group">
            <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full p-1">
                <img class="h-8 w-8 rounded-full object-cover" src="https://placehold.co/32x32/cccccc/333333?text=U" alt="User Avatar">
                <span class="font-medium text-sm hidden sm:block">John Doe</span>
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 hidden group-hover:block">
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
            </header>

            <main class="p-6">
                @yield('content') {{-- This is where content from dashboard.blade.php will be injected --}}
            </main>
        </div>
    </div>

    {{-- Move this script block BEFORE @stack('scripts') --}}
    <script>
        // Dropdown menu toggle (for user profile)
        const userMenuButton = document.querySelector('header .relative > button');
        const userDropdown = document.querySelector('header .relative > div');

        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', () => {
                userDropdown.classList.toggle('hidden');
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', (event) => {
                if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    </script>
<script>
    function updateClock() {
        const now = new Date();

        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0'); // January is 0!
        const year = now.getFullYear();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        document.getElementById('date').textContent = `${day}/${month}/${year}`;
        document.getElementById('time').textContent = `${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateClock, 1000);
    updateClock(); // initial call
</script>

    @stack('scripts') {{-- Your dashboard-specific scripts will be pushed here --}}

</body>
</html>
