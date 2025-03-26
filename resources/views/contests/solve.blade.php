@extends('layouts.dashboard')

@section('title', $problem->title)

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('contests.show', $contest->id) }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="font-medium">Back to Contest</span>
    </a>
</div>

<div class="p-6 space-y-6">
    <!-- Problem Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800">{{ $problem->title }}</h1>
            </div>
            <!-- Check if the problem is already solved by the user -->
            @php
            $solved = $contest->submissions()
            ->where('user_id', auth()->id())
            ->where('problem_id', $problem->id)
            ->where('status', 'Correct')
            ->exists();
            @endphp
            <div class="flex gap-2">
                <span class="px-4 py-2 rounded-lg font-medium 
                    @if($solved) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                    @if($solved) ✅ Solved @else ❌ Unsolved @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Problem Details Grid -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Description Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Description</h3>
                <div class="prose max-w-none text-gray-600">
                    {{ $problem->description }}
                </div>
            </div>

            <!-- Input/Output Format Cards -->
            <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Input Format</h3>
                    <pre class="p-3 bg-gray-50 rounded-lg font-mono text-sm text-gray-800 whitespace-pre-wrap">{{ $problem->input_format }}</pre>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Output Format</h3>
                    <pre class="p-3 bg-gray-50 rounded-lg font-mono text-sm text-gray-800 whitespace-pre-wrap">{{ $problem->output_format }}</pre>
                </div>
            </div>

            <!-- Sample Cases Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Sample Cases</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-500">Input</span>
                        </div>
                        <pre class="p-3 bg-gray-50 rounded-lg font-mono text-sm text-gray-800 whitespace-pre-wrap">{{ $problem->sample_input }}</pre>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-500">Output</span>
                        </div>
                        <pre class="p-3 bg-gray-50 rounded-lg font-mono text-sm text-gray-800 whitespace-pre-wrap">{{ $problem->sample_output }}</pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Editor Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Code Editor</h3>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div id="editor" class="min-h-[400px]"></div>
                </div>
                <form action="{{ route('contests.submit', [$contest->id, $problem->id]) }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="code" id="code">
                    <button type="submit" class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Submit Code
                    </button>
                </form>
            </div>

            <!-- Custom Test Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Custom Test</h3>
                <textarea id="customInput" rows="3" class="w-full p-3 border border-gray-200 rounded-lg font-mono text-sm placeholder-gray-400" placeholder="Enter custom input..."></textarea>
                <div class="mt-4 flex items-center gap-3">
                    <button onclick="runCustomTest()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Run Test
                    </button>
                    <div id="loadingSpinner" class="hidden items-center gap-2 text-gray-500">
                        <svg class="animate-spin h-5 w-5 text-blue-600" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span class="text-sm">Running...</span>
                    </div>
                </div>
                <div id="customOutputBox" class="mt-4 hidden">
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-500">Output</span>
                        </div>
                        <pre id="customOutput" class="font-mono text-sm text-gray-800 whitespace-pre-wrap"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submission Result Modal -->
<div id="submissionResultModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl max-w-md w-full">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 id="resultModalTitle" class="text-xl font-bold text-gray-800"></h3>
                <button onclick="closeModal('submissionResultModal')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="resultModalContent" class="prose prose-sm text-gray-600"></div>
            <div class="mt-4">
                <button onclick="closeModal('submissionResultModal')" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Code Editor
        const editor = ace.edit("editor");
        editor.setTheme("ace/theme/dracula");
        editor.session.setMode("ace/mode/c_cpp");
        editor.session.setValue(`#include <stdio.h>\n\nint main() {\n    // Write your code here\n    return 0;\n}`);
        editor.session.on('change', () => document.getElementById('code').value = editor.getValue());

        // Handle form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const code = editor.getValue().trim();
            if (!code) {
                e.preventDefault();
                alert('Please write some code before submitting!');
            }
        });

        @if(session('status') === 'Correct')
        showSuccessPopup();
        @elseif(session('status') === 'Incorrect')
        showFailedTestCase(
            `{{ addslashes(session('failed_input')) }}`,
            `{{ addslashes(session('expected_output')) }}`,
            `{{ addslashes(session('actual_output')) }}`
        );
        @elseif(session('status') === 'Plagiarized')
        showPlagiarismPopup();
        @endif
    });

    function showSuccessPopup() {
        const modal = document.getElementById('submissionResultModal');
        const title = document.getElementById('resultModalTitle');
        const content = document.getElementById('resultModalContent');

        title.textContent = "✅ Code Accepted!";
        content.innerHTML = `
            <div class="text-center">
                <p class="text-green-600 font-medium">🎉 Congratulations!</p>
                <p>Your solution passed all test cases.</p>
            </div>
        `;
        modal.classList.remove('hidden');
    }

    function showFailedTestCase(input, expected, actual) {
        const modal = document.getElementById('submissionResultModal');
        const title = document.getElementById('resultModalTitle');
        const content = document.getElementById('resultModalContent');

        title.textContent = "❌ Code Rejected";
        content.innerHTML = `
            <div class="space-y-3">
                <p class="font-medium text-red-600">Test Case Failed</p>
                <div class="space-y-2">
                    <div>
                        <p class="text-xs font-medium text-gray-500">Input:</p>
                        <pre class="p-2 bg-gray-50 rounded text-sm">${input.replace(/\n/g, '<br>')}</pre>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Expected Output:</p>
                        <pre class="p-2 bg-green-50 rounded text-sm">${expected.replace(/\n/g, '<br>')}</pre>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Your Output:</p>
                        <pre class="p-2 bg-red-50 rounded text-sm">${actual.replace(/\n/g, '<br>')}</pre>
                    </div>
                </div>
            </div>
        `;
        modal.classList.remove('hidden');
    }

    function showPlagiarismPopup() {
        const modal = document.getElementById('submissionResultModal');
        const title = document.getElementById('resultModalTitle');
        const content = document.getElementById('resultModalContent');

        title.textContent = "⚠️ Plagiarism Detected!";
        content.innerHTML = `
            <div class="text-center">
                <p class="text-yellow-600 font-medium">Your submission is flagged for plagiarism.</p>
                <p>Please submit original code.</p>
            </div>
        `;
        modal.classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    async function runCustomTest() {
        const editor = ace.edit("editor");
        const code = editor.getValue().trim();
        const customInput = document.getElementById('customInput').value;
        const outputBox = document.getElementById('customOutputBox');
        const outputField = document.getElementById('customOutput');
        const spinner = document.getElementById('loadingSpinner');

        if (!code) {
            alert('Please write some code before testing!');
            return;
        }

        spinner.classList.remove('hidden');
        outputBox.classList.add('hidden');

        try {
            const response = await fetch("{{ route('problems.runCustom', $problem->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    code,
                    input: customInput
                })
            });

            const data = await response.json();
            outputField.textContent = data.output || 'No output';
            outputBox.classList.remove('hidden');
        } catch (error) {
            outputField.textContent = 'Error: ' + error.message;
            outputBox.classList.remove('hidden');
        } finally {
            spinner.classList.add('hidden');
        }
    }
</script>
@endsection