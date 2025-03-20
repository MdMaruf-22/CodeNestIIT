@extends('layouts.dashboard')

@section('title', 'Leaderboard - ' . $contest->name)

@section('content')
    <h2 class="text-2xl font-bold">{{ $contest->name }} - Leaderboard</h2>

    <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Rank</th>
                <th class="border p-2">User</th>
                <th class="border p-2">Score</th>
                <th class="border p-2">Penalty</th>
                @foreach ($contest->problems as $problem)
                    <th class="border p-2">{{ $problem->title }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($leaderboard as $index => $entry)
                <tr class="border">
                    <td class="border p-2">{{ $index + 1 }}</td>
                    <td class="border p-2">{{ $entry->user->name }}</td>
                    <td class="border p-2">{{ $entry->total_score }}</td>
                    <td class="border p-2">{{ $entry->last_solved_time }}</td>

                    @foreach ($contest->problems as $problem)
                        @php
                            $submission = $contest->submissions()
                                ->where('user_id', $entry->user_id)
                                ->where('problem_id', $problem->id)
                                ->orderBy('submission_time')
                                ->get();
                            
                            $firstCorrect = $submission->where('status', 'Correct')->first();
                        @endphp
                        <td class="border p-2">
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
@endsection
