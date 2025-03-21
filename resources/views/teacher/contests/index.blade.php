@extends('layouts.dashboard')

@section('title', 'Manage Contests')

@section('content')
<h2 class="text-2xl font-bold">Manage Contests</h2>

<a href="{{ route('teacher.contests.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create Contest</a>

@if(session('success'))
<p class="text-green-600 mt-2">{{ session('success') }}</p>
@endif

<table class="w-full mt-4 border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Name</th>
            <th class="border p-2">Start Time</th>
            <th class="border p-2">End Time</th>
            <th class="border p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contests as $contest)
        <tr>
            <td class="border p-2">{{ $contest->name }}</td>
            <td class="border p-2">{{ $contest->start_time }}</td>
            <td class="border p-2">{{ $contest->end_time }}</td>
            <td class="border p-2">
                <a href="{{ route('teacher.contests.edit', $contest->id) }}" class="text-blue-500">Edit</a> |
                <form action="{{ route('teacher.contests.delete', $contest->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
