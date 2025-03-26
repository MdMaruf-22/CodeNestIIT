@extends('layouts.dashboard')

@section('title', $problem->title)

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('problems.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="font-medium">Back to Problems</span>
    </a>
</div>
<div class="p-6 space-y-6">
    <!-- Problem Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800">{{ $problem->title }}</h1>
                <div class="mt-2 flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @switch($problem->difficulty)
                            @case('Easy') bg-green-100 text-green-800 @break
                            @case('Medium') bg-yellow-100 text-yellow-800 @break
                            @default bg-red-100 text-red-800 
                        @endswitch">
                        {{ $problem->difficulty }}
                    </span>
                    @foreach ($problem->tags_array as $tag)
                    <span class="px-2.5 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                        {{ trim($tag) }}
                    </span>
                    @endforeach
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="showHintModal()" class="flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Hint
                </button>
                <button onclick="showEditorialModal()" class="flex items-center gap-2 px-4 py-2 bg-teal-100 text-teal-600 rounded-lg hover:bg-teal-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Editorial
                </button>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button 
                id="problem-tab" 
                onclick="switchTab('problem')"
                class="px-3 py-4 font-medium text-sm border-b-2 border-blue-500 text-blue-600"
            >
                Problem
            </button>
            <button 
                id="submissions-tab" 
                onclick="switchTab('submissions')"
                class="px-3 py-4 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
            >
                Submissions
            </button>
        </nav>
    </div>

    <!-- Problem Tab Content -->
    <div id="problem-content" class="space-y-6">
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Problem Details -->
            <div class="space-y-6">
                <!-- Description Card -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Description</h3>
                    </div>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($problem->description)) !!}
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

            <!-- Coding Section -->
            <div class="space-y-6">
                <!-- Editor Card -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Code Editor</h3>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div id="editor" class="min-h-[400px]"></div>
                    </div>
                    <form action="{{ route('problems.submit', $problem->id) }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="code" id="code">
                        <button type="submit" class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Submit Solution
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

    <!-- Submissions Tab Content -->
    <div id="submissions-content" class="hidden">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Submission History</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($problem->submissions->where('user_id', auth()->id())->sortByDesc('created_at') as $submission)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium 
                                    {{ $submission->status === 'Correct' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $submission->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <button onclick="showSubmissionCode({{ $submission->id }})" class="text-blue-600 hover:text-blue-900">
                                    View Code
                                </button>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $submission->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">No submissions yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div id="codeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl max-w-3xl w-full">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Submission Code</h3>
                <button onclick="closeModal('codeModal')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 max-h-[70vh] overflow-auto">
                <pre id="submissionCodeContent" class="font-mono text-sm whitespace-pre-wrap"></pre>
            </div>
            <div class="mt-4">
                <button onclick="closeModal('codeModal')" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Hint Modal -->
<div id="hintModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl w-full max-w-2xl shadow-2xl transform transition-all">
        <div class="flex flex-col h-[70vh]">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-t-xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-yellow-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Problem Hint</h3>
                </div>
                <button onclick="closeModal('hintModal')" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto p-6 prose prose-indigo max-w-none">
                @if($problem->hint)
                <div class="space-y-4">
                    {!! nl2br(e($problem->hint)) !!}
                </div>
                @else
                <div class="text-center py-8 text-gray-400">
                    <p>No hint available for this problem.</p>
                </div>
                @endif
            </div>
            <div class="mt-auto p-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
                <button onclick="closeModal('hintModal')" class="w-full px-6 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg transition-colors font-medium">
                    Close Hint
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Editorial Modal -->
<div id="editorialModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl w-full max-w-3xl shadow-2xl transform transition-all">
        <div class="flex flex-col h-[80vh]">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100 rounded-t-xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Problem Editorial</h3>
                </div>
                <button onclick="closeModal('editorialModal')" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto p-6 prose prose-blue max-w-none">
                @if($problem->editorial)
                <div class="space-y-6">
                    <div class="space-y-4">
                        {!! nl2br(e($problem->editorial)) !!}
                    </div>
                    @if($problem->sample_solution)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="font-semibold text-lg mb-3">Sample Solution</h4>
                        <pre class="text-sm bg-white p-4 rounded-lg">{{ $problem->sample_solution }}</pre>
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center py-8 text-gray-400">
                    <p>No editorial available for this problem.</p>
                </div>
                @endif
            </div>
            <div class="mt-auto p-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
                <button onclick="closeModal('editorialModal')" class="w-full px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                    Close Editorial
                </button>
            </div>
        </div>
    </div>
</div>

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

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
<script>
    // Tab Switching Functionality
    function switchTab(tabName) {
        const problemContent = document.getElementById('problem-content');
        const submissionsContent = document.getElementById('submissions-content');
        const problemTabButton = document.getElementById('problem-tab');
        const submissionsTabButton = document.getElementById('submissions-tab');

        if (tabName === 'problem') {
            problemContent.classList.remove('hidden');
            submissionsContent.classList.add('hidden');
            problemTabButton.classList.add('border-blue-500', 'text-blue-600');
            problemTabButton.classList.remove('border-transparent', 'text-gray-500');
            submissionsTabButton.classList.remove('border-blue-500', 'text-blue-600');
            submissionsTabButton.classList.add('border-transparent', 'text-gray-500');
        } else {
            problemContent.classList.add('hidden');
            submissionsContent.classList.remove('hidden');
            submissionsTabButton.classList.add('border-blue-500', 'text-blue-600');
            submissionsTabButton.classList.remove('border-transparent', 'text-gray-500');
            problemTabButton.classList.remove('border-blue-500', 'text-blue-600');
            problemTabButton.classList.add('border-transparent', 'text-gray-500');
        }
    }

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

        // Initialize first tab
        switchTab('problem');
        
        @if(session('status') === 'Correct')
        showSuccessPopup();
        @elseif(session('status') === 'Incorrect')
        showFailedTestCase(
            `{{ addslashes(session('failed_input')) }}`,
            `{{ addslashes(session('expected_output')) }}`,
            `{{ addslashes(session('actual_output')) }}`
        );
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

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function showHintModal() {
        document.getElementById('hintModal').classList.remove('hidden');
    }

    function showEditorialModal() {
        document.getElementById('editorialModal').classList.remove('hidden');
    }
    async function showSubmissionCode(submissionId) {
        const modal = document.getElementById('codeModal');
        const codeContent = document.getElementById('submissionCodeContent');
        
        try {
            const response = await fetch(`/submissions/${submissionId}/code`);
            const data = await response.json();
            
            codeContent.textContent = data.code;
            modal.classList.remove('hidden');
        } catch (error) {
            codeContent.textContent = 'Error loading code: ' + error.message;
            modal.classList.remove('hidden');
        }
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

    // Close modals on outside click
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.classList.add('hidden');
            });
        }
    });
</script>
@endsection