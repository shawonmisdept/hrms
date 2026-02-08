<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-md rounded-xl p-8">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Login to Your Account</h2>

        @if(session('error'))
            <div class="mb-4 text-red-600 text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            </div>

            <div class="mb-4 flex items-center justify-between">
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox text-blue-600">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>
                <div>
                    <a href="#" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Login
                </button>
            </div>
        </form>
    </div>

</body>
</html>
