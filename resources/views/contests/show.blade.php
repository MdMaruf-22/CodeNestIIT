@extends('layouts.dashboard')

@section('title', $contest->name)

@section('content')
<div class="container mx-auto p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('contests.index') }}" 
           class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition duration-300">
            ← Back to Contests
        </a>
    </div>

    <!-- Contest Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-4xl font-bold text-gray-800">{{ $contest->name }}</h2>
        <p class="text-lg text-gray-500">Ends at: {{ $contest->end_time }}</p>
    </div>

    <!-- Countdown Timer -->
    <div class="flex items-center mb-6">
        <h3 class="text-2xl font-semibold text-gray-800">Time Remaining:</h3>
        <p id="countdown" class="ml-4 text-3xl font-bold text-red-600"></p>
    </div>

    <!-- Contest Actions (Results and Leaderboard) -->
    <div class="flex justify-between mb-8">
        @if (now()->greaterThan($contest->end_time))
            <a href="{{ route('contests.results', $contest->id) }}" 
               class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-300">
                View Final Results
            </a>
        @endif
        <a href="{{ route('contests.leaderboard', $contest->id) }}" 
           class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">
            View Leaderboard
        </a>
    </div>

    <!-- Problems List -->
    <div>
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Problems</h3>
        <ul class="space-y-4">
            @foreach ($contest->problems as $problem)
                <li class="p-4 border rounded-lg hover:bg-gray-100 transition duration-300">
                    <a href="{{ route('contests.solve', [$contest->id, $problem->id]) }}" class="text-lg text-blue-600 hover:text-blue-800">
                        {{ $problem->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Discussion Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('contests.discussions', $contest->id) }}" 
           class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300">
            Join Discussion
        </a>
    </div>
</div>

<!-- Countdown Timer Script -->
<script>
    function startCountdown(endTime) {
        let contestEndTime = new Date(endTime).getTime();
        let countdownElement = document.getElementById("countdown");

        let timer = setInterval(function () {
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
