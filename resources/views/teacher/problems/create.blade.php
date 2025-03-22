@extends('layouts.dashboard')

@section('title', 'Create Problem')

@section('content')
<h2 class="text-2xl font-bold">Create Problem</h2>

<form action="{{ route('teacher.problems.store') }}" method="POST" class="mt-4">
    @csrf
    <label class="block">Title:</label>
    <input type="text" name="title" required class="w-full p-2 border rounded">

    <label class="block mt-2">Description:</label>
    <textarea name="description" required class="w-full p-2 border rounded"></textarea>

    <label class="block mt-2">Input Format:</label>
    <textarea name="input_format" required class="w-full p-2 border rounded"></textarea>

    <label class="block mt-2">Output Format:</label>
    <textarea name="output_format" required class="w-full p-2 border rounded"></textarea>

    <label class="block mt-2">Sample Input:</label>
    <textarea name="sample_input" required class="w-full p-2 border rounded"></textarea>

    <label class="block mt-2">Sample Output:</label>
    <textarea name="sample_output" required class="w-full p-2 border rounded"></textarea>

    <label class="block mt-2">Difficulty:</label>
    <select name="difficulty" class="w-full p-2 border rounded">
        <option value="Easy">Easy</option>
        <option value="Medium" selected>Medium</option>
        <option value="Hard">Hard</option>
    </select>

    <label class="block mt-2">Tags (comma-separated):</label>
    <input type="text" name="tags" class="w-full p-2 border rounded" placeholder="Example: Math, DP, Graph">
    <label class="block mt-2">Hint (Optional):</label>
    <textarea name="hint" rows="2" class="w-full p-2 border rounded" placeholder="Short hint">{{ old('hint', $problem->hint ?? '') }}</textarea>

    <label class="block mt-2">Editorial (Optional):</label>
    <textarea name="editorial" rows="6" class="w-full p-2 border rounded" placeholder="Detailed editorial">{{ old('editorial', $problem->editorial ?? '') }}</textarea>
    <button type="submit" class="mt-4 px-6 py-2 bg-blue-500 text-white rounded">Create</button>
</form>
@endsection