@extends('layouts.dashboard')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="p-6">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold">{{ $user->name }}'s Profile</h2>
        <p class="text-lg text-gray-200">Track your progress, contests, and submissions here.</p>
    </div>

    <!-- Statistics Section -->
    <div class="mt-6 grid md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold">📊 Statistics</h3>
            <p class="mt-2"><strong>Total Solved Problems:</strong> <span class="text-green-600">{{ $solvedProblems }}</span></p>
            <p><strong>Total Contests Participated:</strong> <span class="text-blue-600">{{ count($contestsWithSolvedCount) }}</span></p>
        </div>

        <!-- Contests Participated -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold">🏆 Contests Participated</h3>
            @if(count($contestsWithSolvedCount) > 0)
            <table class="w-full mt-4 border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3 text-left">Contest</th>
                        <th class="p-3 text-left">Problems Solved</th>
                        <th class="p-3 text-left">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contestsWithSolvedCount as $contestData)
                    <tr class="border-b">
                        <td class="p-3">{{ $contestData['contest']->name }}</td>
                        <td class="p-3 text-green-600 font-semibold">{{ $contestData['solvedCount'] }}</td>
                        <td class="p-3">
                            <a href="{{ route('contests.show', $contestData['contest']->id) }}" class="text-blue-500 hover:underline">View Contest</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-gray-500 mt-2">No contest history yet.</p>
            @endif
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="mt-6 bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold">📜 Recent Submissions</h3>
        @if(count($submissions) > 0)
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Problem</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $submission)
                <tr class="border-b">
                    <td class="p-3">
                        <a href="{{ route('problems.show', $submission->problem->id) }}"
                            class="text-blue-500 hover:underline">
                            {{ $submission->problem->title }}
                        </a>
                    </td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-white 
                            {{ $submission->status === 'Correct' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $submission->status }}
                        </span>
                    </td>
                    <td class="p-3 text-gray-500">{{ $submission->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-500 mt-2">No recent submissions found.</p>
        @endif
    </div>

</div>
@endsection