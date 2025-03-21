@extends('layouts.dashboard')

@section('title', 'Edit Problem')

@section('content')
<h2 class="text-2xl font-bold">Edit Problem</h2>

<form action="{{ route('teacher.problems.update', $problem->id) }}" method="POST" class="mt-4">
    @csrf

    <label class="block">Title:</label>
    <input type="text" name="title" value="{{ old('title', $problem->title) }}" required class="w-full p-2 border rounded">

    <label class="block mt-2">Description:</label>
    <textarea name="description" rows="6" required class="w-full p-2 border rounded">{{ old('description', $problem->description) }}</textarea>

    <label class="block mt-2">Input Format:</label>
    <textarea name="input_format" rows="4" required class="w-full p-2 border rounded">{{ old('input_format', $problem->input_format) }}</textarea>

    <label class="block mt-2">Output Format:</label>
    <textarea name="output_format" rows="4" required class="w-full p-2 border rounded">{{ old('output_format', $problem->output_format) }}</textarea>

    <label class="block mt-2">Sample Input:</label>
    <textarea name="sample_input" rows="4" required class="w-full p-2 border rounded">{{ old('sample_input', $problem->sample_input) }}</textarea>

    <label class="block mt-2">Sample Output:</label>
    <textarea name="sample_output" rows="4" required class="w-full p-2 border rounded">{{ old('sample_output', $problem->sample_output) }}</textarea>

    <button type="submit" class="mt-4 px-6 py-2 bg-green-500 text-white rounded">Update Problem</button>
    <a href="{{ route('teacher.problems') }}" class="mt-4 px-6 py-2 bg-gray-500 text-white rounded">Cancel</a>
</form>
@endsection
