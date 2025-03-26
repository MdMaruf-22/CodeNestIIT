<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CodeNestIIT</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Use Tailwind for styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css">
</head>

<body class="bg-gray-100">

    <!-- Navigation Bar -->
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-xl font-bold">CodeNestIIT</h1>
            <div>
            <a href="{{ auth()->user()->role === 'student' ? url('student/dashboard') : url('teacher/dashboard') }}" class="px-4">
        Dashboard
    </a>
                <a href="{{ route('logout') }}" class="px-4"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <a href="{{ route('profile.show', auth()->user()->id) }}" class="px-4">
                    View Profile
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container mx-auto mt-6 p-4">
        @yield('content')
    </div>

</body>

</html>