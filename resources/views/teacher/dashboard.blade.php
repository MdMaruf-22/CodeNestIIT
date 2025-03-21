@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('content')
<h2 class="text-2xl font-bold">Welcome, Teacher!</h2>
<p class="text-gray-700">Here you can manage contests, problems, and evaluate submissions.</p>

<!-- Contest Management -->
<div class="mt-6 p-4 bg-white rounded shadow">
    <h3 class="text-xl font-semibold">Contest Management</h3>
    <a href="{{ route('contests.create') }}" class="mt-2 inline-block px-4 py-2 bg-green-500 text-white rounded">Create Contest</a>
    <a href="{{ route('teacher.contests') }}" class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded">Manage Contests</a>
</div>

<!-- Problem Management -->
<div class="mt-6 p-4 bg-white rounded shadow">
    <h3 class="text-xl font-semibold">Problem Management</h3>
    <a href="{{ route('teacher.problems.create') }}" class="mt-2 inline-block px-4 py-2 bg-green-500 text-white rounded">Create Problem</a>
    <a href="{{ route('teacher.problems') }}" class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded">Manage Problems</a>
</div>

@endsection
