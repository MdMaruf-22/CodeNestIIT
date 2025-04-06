<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | CodeNestIIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

    <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden px-4">

        {{-- Top Login/Register --}}
        @if (Route::has('login'))
        <div class="absolute top-5 right-5 space-x-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-red-500 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-red-500 transition">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-red-500 transition">Register</a>
                @endif
            @endauth
        </div>
        @endif

        {{-- Hero Section --}}
        <div class="max-w-2xl text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight tracking-tight">
                Welcome to <span class="text-red-500">CodeNestIIT</span>
            </h1>
            <p class="text-lg md:text-xl mb-8 text-gray-600 dark:text-gray-400">
                A powerful platform to enhance your coding skills, participate in contests, track your progress and grow with a community of passionate learners.
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-red-500 text-white rounded-xl shadow hover:bg-red-600 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-xl shadow hover:bg-gray-300 dark:hover:bg-gray-700 transition">
                    Register
                </a>
            </div>
        </div>

        {{-- Background Decoration --}}
        <div class="absolute -top-10 -left-10 w-72 h-72 bg-red-500 opacity-20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-indigo-500 opacity-20 rounded-full blur-3xl animate-pulse"></div>

        {{-- Footer --}}
        <footer class="absolute bottom-5 text-sm text-gray-400">
            &copy; 2025 Mohammed Maruf Islam. All rights reserved.
        </footer>

    </div>

</body>
</html>
