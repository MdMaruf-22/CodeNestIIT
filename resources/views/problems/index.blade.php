@extends('layouts.dashboard')

@section('title', 'Problem Repository')

@section('content')
    <h2 class="text-2xl font-bold">Problem Repository</h2>
    <p class="text-gray-700">Browse available programming problems.</p>

    <ul class="mt-4 space-y-2">
        @foreach ($problems as $problem)
            <li class="p-4 bg-white rounded shadow">
                <a href="{{ route('problems.show', $problem->id) }}" class="text-blue-600 font-semibold">{{ $problem->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection
