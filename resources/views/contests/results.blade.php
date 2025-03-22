@extends('layouts.dashboard')

@section('title', 'Contest Results - ' . $contest->name)

@section('content')
<h2 class="text-2xl font-bold">{{ $contest->name }} - Final Results</h2>

@if(session('error'))
<p class="text-red-500">{{ session('error') }}</p>
@endif

<table class="w-full mt-4 border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Rank</th>
            <th class="border p-2">User</th>
            <th class="border p-2">Score</th>
            <th class="border p-2">Penalty</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaderboard as $index => $entry)
        <tr class="border">
            <td class="border p-2">{{ $index + 1 }}</td>
            <td class="border p-2">{{ $entry->user->name }}</td>
            <td class="border p-2">{{ $entry->total_score }}</td>
            <td class="border p-2">{{ $entry->last_solved_time }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
