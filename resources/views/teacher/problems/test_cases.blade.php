@extends('layouts.dashboard')

@section('title', 'Manage Test Cases - ' . $problem->title)

@section('content')
<h2 class="text-2xl font-bold">Manage Test Cases for {{ $problem->title }}</h2>

@if(session('success'))
<p class="text-green-600">{{ session('success') }}</p>
@endif

<form action="{{ route('teacher.test_cases.store', $problem->id) }}" method="POST" class="mt-4">
    @csrf
    <label class="block">Input:</label>
    <textarea name="input" required class="w-full p-2 border rounded"></textarea>

    <label class="block mt-2">Expected Output:</label>
    <textarea name="expected_output" required class="w-full p-2 border rounded"></textarea>

    <label class="block mt-2">
        <input type="checkbox" name="is_sample"> Mark as Sample
    </label>

    <button type="submit" class="mt-4 px-6 py-2 bg-blue-500 text-white rounded">Add Test Case</button>
</form>

<h3 class="font-semibold mt-6">Existing Test Cases</h3>
<table class="w-full mt-4 border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Input</th>
            <th class="border p-2">Expected Output</th>
            <th class="border p-2">Type</th>
            <th class="border p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($problem->testCases as $testCase)
        <tr class="border">
            <td class="border p-2"><pre>{{ $testCase->input }}</pre></td>
            <td class="border p-2"><pre>{{ $testCase->expected_output }}</pre></td>
            <td class="border p-2">{{ $testCase->is_sample ? 'Sample' : 'Hidden' }}</td>
            <td class="border p-2">
                <form action="{{ route('teacher.test_cases.delete', $testCase->id) }}" method="POST">
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
