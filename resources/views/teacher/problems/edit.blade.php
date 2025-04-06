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

    <!-- Difficulty Selection -->
    <label class="block mt-2">Difficulty:</label>
    <select name="difficulty" class="w-full p-2 border rounded">
        <option value="Easy" {{ $problem->difficulty == 'Easy' ? 'selected' : '' }}>Easy</option>
        <option value="Medium" {{ $problem->difficulty == 'Medium' ? 'selected' : '' }}>Medium</option>
        <option value="Hard" {{ $problem->difficulty == 'Hard' ? 'selected' : '' }}>Hard</option>
    </select>

    <!-- Tags Input -->
    <label class="block mt-2">Tags (comma-separated):</label>
    <input type="text" name="tags" value="{{ old('tags', $problem->tags) }}" class="w-full p-2 border rounded" placeholder="Example: Math, DP, Graph">
    <label class="block mt-2">Hint (Optional):</label>
    <textarea name="hint" rows="2" class="w-full p-2 border rounded" placeholder="Short hint">{{ old('hint', $problem->hint ?? '') }}</textarea>

    <label class="block mt-2">Editorial (Optional):</label>
    <textarea name="editorial" rows="6" class="w-full p-2 border rounded" placeholder="Detailed editorial">{{ old('editorial', $problem->editorial ?? '') }}</textarea>
    <!-- Test Cases Section -->
    <label class="block font-medium text-gray-700 mt-4 mb-2">Test Cases:</label>
    <div id="test-cases-wrapper" class="space-y-4">
    @foreach($testCases as $index => $tc)
<div class="test-case border border-gray-300 rounded-lg p-4" data-index="{{ $index }}">
    <input type="hidden" name="test_cases[{{ $index }}][id]" value="{{ $tc->id }}">
    
    <div class="flex justify-between items-center mb-2">
        <h4 class="font-semibold">Test Case #{{ $index + 1 }}</h4>
        <button type="button" onclick="toggleCollapse(this)" class="text-sm text-blue-600 hover:underline">Collapse</button>
    </div>

    <div class="test-case-body space-y-3">
        <div>
            <label class="block text-sm font-semibold mb-1">Input:</label>
            <textarea name="test_cases[{{ $index }}][input]" required class="w-full p-2 border rounded" oninput="updatePreview(this, 'input')">{{ $tc->input }}</textarea>
            <div class="mt-1 text-xs text-gray-500">Preview: <span class="preview-input whitespace-pre-wrap">{{ $tc->input }}</span></div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Expected Output:</label>
            <textarea name="test_cases[{{ $index }}][output]" required class="w-full p-2 border rounded" oninput="updatePreview(this, 'output')">{{ $tc->expected_output }}</textarea>
            <div class="mt-1 text-xs text-gray-500">Preview: <span class="preview-output whitespace-pre-wrap">{{ $tc->expected_output }}</span></div>
        </div>

        <button type="button" onclick="removeTestCase(this)" class="text-red-500 hover:text-red-700 text-sm">❌ Remove</button>
    </div>
</div>
@endforeach

    </div>

    <button type="button" onclick="addTestCase()" class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition">
        ➕ Add Test Case
    </button>

    <button type="submit" class="mt-4 px-6 py-2 bg-green-500 text-white rounded">Update Problem</button>
    <a href="{{ route('teacher.problems') }}" class="mt-4 px-6 py-2 bg-gray-500 text-white rounded">Cancel</a>
</form>
@endsection
@push('scripts')
<script>
    let testCaseIndex = {{ count($testCases) }};

    function addTestCase() {
        const wrapper = document.getElementById('test-cases-wrapper');
        const div = document.createElement('div');
        div.className = 'test-case border border-gray-300 rounded-lg p-4';
        div.dataset.index = testCaseIndex;

        div.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <h4 class="font-semibold">Test Case #${testCaseIndex + 1}</h4>
                <button type="button" onclick="toggleCollapse(this)" class="text-sm text-blue-600 hover:underline">Collapse</button>
            </div>
            <div class="test-case-body space-y-3">
                <div>
                    <label class="block text-sm font-semibold mb-1">Input:</label>
                    <textarea name="test_cases[${testCaseIndex}][input]" required class="w-full p-2 border rounded" oninput="updatePreview(this, 'input')"></textarea>
                    <div class="mt-1 text-xs text-gray-500">Preview: <span class="preview-input whitespace-pre-wrap"></span></div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Expected Output:</label>
                    <textarea name="test_cases[${testCaseIndex}][output]" required class="w-full p-2 border rounded" oninput="updatePreview(this, 'output')"></textarea>
                    <div class="mt-1 text-xs text-gray-500">Preview: <span class="preview-output whitespace-pre-wrap"></span></div>
                </div>

                <button type="button" onclick="removeTestCase(this)" class="text-red-500 hover:text-red-700 text-sm">❌ Remove</button>
            </div>
        `;

        wrapper.appendChild(div);
        testCaseIndex++;
    }

    function removeTestCase(button) {
        const testCase = button.closest('.test-case');
        testCase.remove();
    }

    function toggleCollapse(button) {
        const body = button.closest('.test-case').querySelector('.test-case-body');
        const isCollapsed = body.style.display === 'none';

        body.style.display = isCollapsed ? 'block' : 'none';
        button.textContent = isCollapsed ? 'Collapse' : 'Expand';
    }

    function updatePreview(textarea, type) {
        const preview = textarea.closest('div').querySelector(`.preview-${type}`);
        preview.textContent = textarea.value;
    }
</script>
@endpush