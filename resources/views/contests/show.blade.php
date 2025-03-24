@extends('layouts.dashboard')

@section('title', $contest->name)

@section('content')
<h2 class="text-2xl font-bold">{{ $contest->name }}</h2>
<p>Ends at: {{ $contest->end_time }}</p>

<!-- Contest Timer -->
<h3 class="text-xl font-semibold mt-4">Time Remaining:</h3>
<p id="countdown" class="text-red-500 text-lg font-bold"></p>
@if (now()->greaterThan($contest->end_time))
    <a href="{{ route('contests.results', $contest->id) }}" class="mt-4 inline-block px-4 py-2 bg-purple-500 text-white rounded">
        View Final Results
    </a>
@endif
<a href="{{ route('contests.leaderboard', $contest->id) }}"
    class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">
    View Leaderboard
</a>

<h3 class="mt-4 font-semibold">Problems</h3>
<ul class="mt-2">
    @foreach ($contest->problems as $problem)
    <li class="p-2 bg-gray-200 rounded mb-2">
        <a href="{{ route('contests.solve', [$contest->id, $problem->id]) }}" class="text-blue-600">
            {{ $problem->title }}
        </a>
    </li>
    @endforeach
</ul>
<a href="{{ route('contests.discussions', $contest->id) }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">
    Join Discussion
</a>
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
