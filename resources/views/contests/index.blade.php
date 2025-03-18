@extends('layouts.dashboard')

@section('title', 'Contests')

@section('content')
    <h2 class="text-2xl font-bold">All Contests</h2>

    <!-- Show "Create Contest" Button for Teachers Only -->
    @if (auth()->user()->role === 'teacher')
        <a href="{{ route('contests.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create Contest</a>
    @endif

    <ul class="mt-4">
        @foreach ($contests as $contest)
            <li class="p-4 bg-white rounded shadow mb-2">
                <h3 class="font-semibold">{{ $contest->name }}</h3>
                <p>Starts: {{ $contest->start_time }}</p>
                <p>Ends: {{ $contest->end_time }}</p>

                <!-- "Enter Contest" Button -->
                <a href="{{ route('contests.show', $contest->id) }}" 
                   class="mt-2 inline-block px-4 py-2 bg-green-500 text-white rounded">
                    Enter Contest
                </a>
            </li>
        @endforeach
    </ul>
@endsection
