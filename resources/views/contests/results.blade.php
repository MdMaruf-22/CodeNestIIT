@extends('layouts.dashboard')

@section('title', 'Contest Results - ' . $contest->name)

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
        <h2 class="text-4xl font-bold text-gray-900">{{ $contest->name }} - Final Results</h2>
    </div>

    @if(session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md mb-4">
        {{ session('error') }}
    </div>
    @endif

    <!-- Results Table -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="w-full mt-4 table-auto border-collapse">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-4 text-center">Rank</th>
                    <th class="border p-4 text-left">User</th>
                    <th class="border p-4 text-center">Total Score</th>
                    <th class="border p-4 text-center">Correct Submissions</th>
                    <th class="border p-4 text-center">Penalty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaderboard as $index => $entry)
                <tr class="text-gray-900 hover:bg-gray-100 transition duration-200">
                    <td class="border p-4 text-center font-semibold 
                            @if ($index == 0) bg-yellow-500 text-white 
                            @elseif ($index == 1) bg-gray-400 text-white 
                            @elseif ($index == 2) bg-amber-400 text-white 
                            @endif">
                        {{ $index + 1 }}
                    </td>
                    <td class="border p-4 text-left">{{ $entry->user->name }}</td>
                    <td class="border p-4 text-center font-semibold text-blue-600">{{ $entry->total_score }}</td>
                    <td class="border p-4 text-center font-semibold text-green-600">{{ $entry->correct_submissions }}</td>
                    <td class="border p-4 text-center font-semibold">{{ $entry->last_solved_time }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
