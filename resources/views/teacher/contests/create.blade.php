@extends('layouts.dashboard')

@section('title', 'Create Contest')

@section('content')
<h2 class="text-2xl font-bold">Create Contest</h2>

<form action="{{ route('teacher.contests.store') }}" method="POST" class="mt-4">
    @csrf
    <label class="block">Name:</label>
    <input type="text" name="name" required class="w-full p-2 border rounded">

    <label class="block mt-2">Start Time:</label>
    <input type="datetime-local" name="start_time" required class="w-full p-2 border rounded">

    <label class="block mt-2">End Time:</label>
    <input type="datetime-local" name="end_time" required class="w-full p-2 border rounded">

    <button type="submit" class="mt-4 px-6 py-2 bg-blue-500 text-white rounded">Create</button>
</form>
@endsection
