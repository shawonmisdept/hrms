<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'nHRMS Dashboard')</title> {{-- এখানে পরিবর্তন --}}

    {{-- REPLACE the old asset() calls with @vite directive --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome for Icons (if not included in app.css or via Vite) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    @stack('styles')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div id="app" class="flex h-screen">
        {{-- Sidebar or Navigation goes here --}}
        <aside class="w-64 bg-gray-800 text-white p-4">
            <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('employees.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Employees</a></li>
                    {{-- Add other dashboard links --}}
                </ul>
            </nav>
        </aside>

        <div class="flex-1 overflow-x-hidden overflow-y-auto">
            {{-- Header or Navbar inside the main content area --}}
            <header class="w-full bg-white shadow py-4 px-6 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Page')</h2>
                {{-- User dropdown/profile etc. --}}
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full p-1">
                            <img class="h-8 w-8 rounded-full object-cover" src="https://placehold.co/32x32/cccccc/333333?text=U" alt="User Avatar">
                            <span class="font-medium text-sm hidden sm:block">John Doe</span>
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
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

    @stack('scripts') {{-- Your dashboard-specific scripts will be pushed here --}}

</body>
</html>
