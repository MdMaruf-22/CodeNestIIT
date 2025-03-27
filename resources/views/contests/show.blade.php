@extends('layouts.dashboard')

@section('title', $contest->name)

@section('content')
<div class="container mx-auto p-6">
    <!-- Back Button -->
    <div class="-mt-10 mb-12">
        <a href="{{ route('contests.index') }}"
            class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 
              rounded-lg font-medium text-sm text-white hover:from-indigo-700 hover:to-blue-600 
              focus:outline-none focus:ring-1 focus:ring-indigo-300 transition-all duration-150 
              shadow hover:shadow-lg transform hover:scale-[1.02]">
            <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Contest
        </a>
    </div>

    <div class="flex justify-between items-center mb-3 p-4 bg-white border-l-4 border-blue-600 rounded-lg shadow-md">
        <h2 class="text-4xl font-extrabold text-gray-800">{{ $contest->name }}</h2>
        <p class="text-lg font-medium text-gray-600">Ends: {{ $contest->end_time }}</p>
    </div>

    <!-- Countdown Timer -->
    <div class="flex items-center justify-center mt-3 mb-5 p-3 bg-gray-100 rounded-lg shadow">
        <h3 class="text-2xl font-semibold text-gray-800">Remaining:</h3>
        <p id="countdown" class="ml-3 text-3xl font-extrabold text-red-600"></p>
    </div>

    <!-- Contest Actions -->
    <div class="flex justify-center gap-6 mb-6">
        @if (now()->greaterThan($contest->end_time))
        <a href="{{ route('contests.results', $contest->id) }}"
            class="px-6 py-2 bg-gray-700 text-lg font-medium text-white rounded-lg shadow-md hover:bg-gray-800 transition-transform transform hover:scale-105">
            🏆 Final Results
        </a>
        @endif
        <a href="{{ route('contests.leaderboard', $contest->id) }}"
            class="px-6 py-2 bg-blue-600 text-lg font-medium text-white rounded-lg shadow-md hover:bg-blue-700 transition-transform transform hover:scale-105">
            📊 Leaderboard
        </a>
    </div>


    <!-- Problems List -->
    <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Problems</h3>
        <ul class="space-y-2"> <!-- Reduced spacing -->
            @foreach ($contest->problems as $problem)
            <li class="p-2 border rounded-md hover:bg-gray-50 transition duration-200">
                <a href="{{ route('contests.solve', [$contest->id, $problem->id]) }}"
                    class="text-md text-blue-600 hover:text-blue-800 hover:underline">
                    {{ $problem->title }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Discussion Button -->
    <div class="mt-5 text-center">
        <a href="{{ route('contests.discussions', $contest->id) }}"
            class="px-4 py-1.5 bg-green-500 text-sm text-white rounded-md hover:bg-green-600 transition duration-200">
            Join Discussion
        </a>
    </div>

    <!-- Countdown Timer Script -->
    <script>
        function startCountdown(endTime) {
            let contestEndTime = new Date(endTime).getTime();
            let countdownElement = document.getElementById("countdown");

            let timer = setInterval(function() {
                let now = new Date().getTime();
                let timeLeft = contestEndTime - now;

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    countdownElement.innerHTML = "⏳ Contest Ended";
                    return;
                }

                let hours = Math.floor(timeLeft / (1000 * 60 * 60));
                let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                countdownElement.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
            }, 1000);
        }

        // Start the countdown
        startCountdown("{{ $contest->end_time }}");
    </script>

    @endsection