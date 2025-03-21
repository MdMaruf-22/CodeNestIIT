@extends('layouts.dashboard')

@section('title', 'Manage Problems')

@section('content')
<h2 class="text-2xl font-bold">Manage Problems</h2>

<a href="{{ route('teacher.problems.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create Problem</a>

@if(session('success'))
<p class="text-green-600 mt-2">{{ session('success') }}</p>
@endif

<table class="w-full mt-4 border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Title</th>
            <th class="border p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($problems as $problem)
        <tr>
            <td class="border p-2">{{ $problem->title }}</td>
            <td class="border p-2">
                <a href="{{ route('teacher.problems.edit', $problem->id) }}" class="text-blue-500">Edit</a> |
                <form action="{{ route('teacher.problems.delete', $problem->id) }}" method="POST" class="inline">
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
