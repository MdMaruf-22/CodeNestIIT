@extends('layouts.dashboard')

@section('title', 'Leaderboard - ' . $contest->name)

@section('content')
<div class="container mx-auto p-6 max-w-screen-xl">
    <div class="-mt-10 mb-12"> 
        <a href="{{ route('contests.show', $contest) }}"
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
    <!-- Contest Title -->
    <div class="mb-6">
        <h2 class="text-4xl font-bold text-gray-900">{{ $contest->name }} - Leaderboard</h2>
    </div>

    <!-- Leaderboard Table -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="w-full mt-4 table-auto border-collapse">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-4 text-center">Rank</th>
                    <th class="border p-4 text-left">User</th>
                    <th class="border p-4 text-center">Score</th>
                    <th class="border p-4 text-center">Penalty</th>
                    @foreach ($contest->problems as $problem)
                    <th class="border p-4 text-center">{{ $problem->title }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($leaderboard as $index => $entry)
                <tr class="text-gray-900 hover:bg-gray-100 transition duration-200">
                    <td class="border p-4 text-center font-semibold 
                            @if ($index == 0) bg-yellow-500 text-white @elseif ($index == 1) bg-gray-400 text-white @elseif ($index == 2) bg-amber-400 text-white @endif">
                        {{ $index + 1 }}
                    </td>
                    <td class="border p-4 text-left">{{ $entry->user->name }}</td>
                    <td class="border p-4 text-center font-semibold">{{ $entry->total_score }}</td>
                    <td class="border p-4 text-center font-semibold">{{ $entry->last_solved_time }}</td>

                    @foreach ($contest->problems as $problem)
                    @php
                    $submission = $contest->submissions()
                    ->where('user_id', $entry->user_id)
                    ->where('problem_id', $problem->id)
                    ->orderBy('submission_time')
                    ->get();

                    $firstCorrect = $submission->where('status', 'Correct')->first();
                    @endphp
                    <td class="border p-4 text-center 
                                @if ($firstCorrect) bg-green-100 text-green-600 @else bg-red-100 text-red-600 @endif">
                        @if ($firstCorrect)
                        ✅ ({{ $firstCorrect->submission_time }} min)
                        @else
                        ❌
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection