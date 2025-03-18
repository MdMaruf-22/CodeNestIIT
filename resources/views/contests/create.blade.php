@extends('layouts.dashboard')

@section('title', 'Create Contest')

@section('content')
    <h2 class="text-2xl font-bold">Create a New Contest</h2>

    <form action="{{ route('contests.store') }}" method="POST" class="mt-4">
        @csrf
        <label class="block">Contest Name:</label>
        <input type="text" name="name" class="w-full p-2 border rounded" required>

        <label class="block mt-4">Start Time:</label>
        <input type="datetime-local" name="start_time" class="w-full p-2 border rounded" required>

        <label class="block mt-4">End Time:</label>
        <input type="datetime-local" name="end_time" class="w-full p-2 border rounded" required>

        <label class="block mt-4">Select Problems:</label>
        @foreach ($problems as $problem)
            <div>
                <input type="checkbox" name="problems[]" value="{{ $problem->id }}">
                <label>{{ $problem->title }}</label>
            </div>
        @endforeach

        <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Create Contest</button>
    </form>
@endsection
