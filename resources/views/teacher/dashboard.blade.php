@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('content')
    <h2 class="text-2xl font-bold">Welcome, Teacher!</h2>
    <p class="text-gray-700">Here you can create contests, evaluate submissions, and provide feedback.</p>
    <a href="{{ route('contests.create') }}" class="mt-4 inline-block px-6 py-2 bg-blue-500 text-white rounded">Create a Contest</a>
@endsection
