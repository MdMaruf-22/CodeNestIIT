@extends('layouts.dashboard')

@section('title', $user->name . "'s Profile")

@section('content')
<h2 class="text-3xl font-bold">{{ $user->name }}'s Profile</h2>

<div class="mt-6 p-4 bg-white rounded shadow">
    <h3 class="text-xl font-semibold">Statistics</h3>
    <p><strong>Total Solved Problems:</strong> {{ $solvedProblems }}</p>
    <p><strong>Total Contests Participated:</strong> {{ count($contestsWithSolvedCount) }}</p>
</div>

<div class="mt-6 p-4 bg-white rounded shadow">
    <h3 class="text-xl font-semibold">Contests Participated</h3>
    <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Contest</th>
                <th class="border p-2">Problems Solved</th>
                <th class="border p-2">Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contestsWithSolvedCount as $contestData)
            <tr class="border">
                <td class="border p-2">{{ $contestData['contest']->name }}</td>
                <td class="border p-2 text-green-600">{{ $contestData['solvedCount'] }}</td>
                <td class="border p-2">
                    <a href="{{ route('contests.show', $contestData['contest']->id) }}" class="text-blue-500">View Contest</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6 p-4 bg-white rounded shadow">
    <h3 class="text-xl font-semibold">Recent Submissions</h3>
    <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Problem</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($submissions as $submission)
            <tr class="border">
                <td class="border p-2">{{ $submission->problem->title }}</td>
                <td class="border p-2 {{ $submission->status === 'Correct' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $submission->status }}
                </td>
                <td class="border p-2">{{ $submission->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
