<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CodeNestIIT') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-gray-100 to-gray-300 dark:from-gray-900 dark:to-gray-800">
    <div class="min-h-screen flex flex-col justify-center items-center px-4">
        
        {{-- Optional Custom Logo or App Name --}}
        <a href="/" class="text-3xl font-extrabold text-gray-700 dark:text-white mb-8">
            CodeNest<span class="text-red-500">IIT</span>
        </a>

        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
            © {{ date('Y') }} CodeNestIIT. All rights reserved.
        </div>

    </div>
</body>
</html>
