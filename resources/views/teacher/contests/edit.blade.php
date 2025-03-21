@extends('layouts.dashboard')

@section('title', 'Edit Contest')

@section('content')
<h2 class="text-2xl font-bold">Edit Contest</h2>

<form action="{{ route('teacher.contests.update', $contest->id) }}" method="POST" class="mt-4">
    @csrf
    <label class="block">Name:</label>
    <input type="text" name="name" value="{{ $contest->name }}" required class="w-full p-2 border rounded">

    <label class="block mt-2">Start Time:</label>
    <input type="datetime-local" name="start_time" value="{{ $contest->start_time }}" required class="w-full p-2 border rounded">

    <label class="block mt-2">End Time:</label>
    <input type="datetime-local" name="end_time" value="{{ $contest->end_time }}" required class="w-full p-2 border rounded">

    <button type="submit" class="mt-4 px-6 py-2 bg-green-500 text-white rounded">Update</button>
</form>
@endsection
