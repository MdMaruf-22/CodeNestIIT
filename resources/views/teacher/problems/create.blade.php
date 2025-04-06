@extends('layouts.dashboard')

@section('title', 'Create Problem')

@section('content')
<!-- Back Button -->
<div class="-mt-4 mb-6">
    <a href="{{ route('problems.index') }}"
        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-500 
              rounded-lg font-semibold text-sm text-white hover:from-purple-700 hover:to-indigo-600 
              focus:outline-none focus:ring-2 focus:ring-purple-300 transition-all duration-150 
              shadow hover:shadow-lg transform hover:scale-[1.02]">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Problem
    </a>
</div>

<!-- Container -->
<div class="container mx-auto max-w-3xl bg-white p-8 rounded-xl shadow-xl">
    <!-- Header -->
    <div class="mb-6 text-center">
        <h2 class="text-4xl font-extrabold text-gray-800">📝 Create a New Problem</h2>
        <p class="text-gray-500 mt-2">Fill in the details below to add a problem to your contest set.</p>
    </div>

    <!-- Form -->
    <form action="{{ route('teacher.problems.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block font-medium text-gray-700">Title:</label>
            <input type="text" name="title" required
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Description:</label>
            <textarea name="description" required rows="4"
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Input Format:</label>
            <textarea name="input_format" required
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Output Format:</label>
            <textarea name="output_format" required
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Sample Input:</label>
            <textarea name="sample_input" required
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Sample Output:</label>
            <textarea name="sample_output" required
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Difficulty:</label>
            <select name="difficulty"
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                <option value="Easy">Easy</option>
                <option value="Medium" selected>Medium</option>
                <option value="Hard">Hard</option>
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Tags (comma-separated):</label>
            <input type="text" name="tags"
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"
                placeholder="Example: Math, DP, Graph">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Hint (Optional):</label>
            <textarea name="hint" rows="2"
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"
                placeholder="Short hint">{{ old('hint', $problem->hint ?? '') }}</textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Editorial (Optional):</label>
            <textarea name="editorial" rows="5"
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"
                placeholder="Detailed editorial">{{ old('editorial', $problem->editorial ?? '') }}</textarea>
        </div>
        <div>
            <label class="block font-medium text-gray-700 mb-2">Test Cases:</label>
            <div id="test-cases-wrapper" class="space-y-4">
                <!-- Initial Test Case -->
                <div class="test-case border border-gray-300 rounded-lg p-4" data-index="0">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-semibold">Test Case #1</h4>
                        <button type="button" onclick="toggleCollapse(this)" class="text-sm text-blue-600 hover:underline">Collapse</button>
                    </div>
                    <div class="test-case-body space-y-3">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Input:</label>
                            <textarea name="test_cases[0][input]" required class="w-full p-2 border rounded" oninput="updatePreview(this, 'input')"></textarea>
                            <div class="mt-1 text-xs text-gray-500">Preview: <span class="preview-input whitespace-pre-wrap"></span></div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Expected Output:</label>
                            <textarea name="test_cases[0][output]" required class="w-full p-2 border rounded" oninput="updatePreview(this, 'output')"></textarea>
                            <div class="mt-1 text-xs text-gray-500">Preview: <span class="preview-output whitespace-pre-wrap"></span></div>
                        </div>

                        <button type="button" onclick="removeTestCase(this)"
                            class="text-red-500 hover:text-red-700 text-sm">❌ Remove</button>
                    </div>
                </div>
            </div>
            <button type="button" onclick="addTestCase()"
                class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition">
                ➕ Add Test Case
            </button>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit"
                class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow-md transition duration-300 transform hover:scale-[1.02]">
                ✅ Create Problem
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let testCaseIndex = 1;

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
