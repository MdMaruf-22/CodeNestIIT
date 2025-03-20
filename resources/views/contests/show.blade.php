@extends('layouts.dashboard')

@section('title', $contest->name)

@section('content')
<h2 class="text-2xl font-bold">{{ $contest->name }}</h2>
<p>Ends at: {{ $contest->end_time }}</p>
<a href="{{ route('contests.leaderboard', $contest->id) }}"
    class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">
    View Leaderboard
</a>
<h3 class="mt-4 font-semibold">Problems</h3>
<ul class="mt-2">
    @foreach ($contest->problems as $problem)
    <li class="p-2 bg-gray-200 rounded mb-2">
        <a href="{{ route('contests.solve', [$contest->id, $problem->id]) }}" class="text-blue-600">{{ $problem->title }}</a>
    </li>
    @endforeach
</ul>
@endsection