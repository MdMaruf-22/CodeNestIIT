@extends('layouts.dashboard')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="p-6">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold">{{ $user->name }}'s Profile</h2>
        <p class="text-lg text-gray-200">Track your progress, contests, and submissions here.</p>
    </div>

    <!-- Statistics Section -->
    <div class="mt-6 grid md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold">📊 Statistics</h3>
            <p class="mt-2"><strong>Total Solved Problems:</strong> <span class="text-green-600">{{ $solvedProblems }}</span></p>
            <p><strong>Total Contests Participated:</strong> <span class="text-blue-600">{{ count($contestsWithSolvedCount) }}</span></p>
        </div>

        <!-- Contests Participated -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold">🏆 Contests Participated</h3>
            @if(count($contestsWithSolvedCount) > 0)
            <table class="w-full mt-4 border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3 text-left">Contest</th>
                        <th class="p-3 text-left">Problems Solved</th>
                        <th class="p-3 text-left">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contestsWithSolvedCount as $contestData)
                    <tr class="border-b">
                        <td class="p-3">{{ $contestData['contest']->name }}</td>
                        <td class="p-3 text-green-600 font-semibold">{{ $contestData['solvedCount'] }}</td>
                        <td class="p-3">
                            <a href="{{ route('contests.show', $contestData['contest']->id) }}" class="text-blue-500 hover:underline">View Contest</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-gray-500 mt-2">No contest history yet.</p>
            @endif
        </div>
    </div>

    <div class="mt-6 bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold">📜 All Submissions</h3>
        @if(count($allSubmissions) > 0)
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Problem</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Time</th>
                    <th class="p-3 text-left">Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allSubmissions as $submission)
                <tr class="border-b">
                    <td class="p-3">
                        <a href="{{ route('problems.show', $submission->problem->id) }}"
                            class="text-blue-500 hover:underline">
                            {{ $submission->problem->title }}
                        </a>
                    </td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-white 
                    {{ $submission->status === 'Correct' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $submission->status }}
                        </span>
                    </td>
                    <td class="p-3 text-gray-500">{{ $submission->created_at->diffForHumans() }}</td>
                    <td class="p-3">
                        <a href="#"
                            class="text-blue-500 hover:underline view-code"
                            data-code="{{ htmlspecialchars($submission->code) }}">
                            View Code
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-500 mt-2">No submissions found.</p>
        @endif
    </div>

    <!-- Code Modal -->
    <div id="codeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="relative top-20 mx-auto p-5 border w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium mb-4">Submitted Code</h3>
                <div class="bg-gray-100 p-4 rounded-md">
                    <pre class="overflow-x-auto max-h-[70vh]"><code id="modalCodeContent" class="language-c whitespace-pre text-sm"></code></pre>
                </div>
                <div class="mt-4 flex justify-end">
                    <button id="modalCloseBtn"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('codeModal');
            const modalContent = document.getElementById('modalCodeContent');
            const closeBtn = document.getElementById('modalCloseBtn');
            hljs.configure({
                ignoreUnescapedHTML: true,
                languages: ['c']
            });
            document.querySelectorAll('.view-code').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const code = this.dataset.code;
                    modalContent.innerHTML = code.replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    hljs.highlightElement(modalContent);
                    modal.classList.remove('hidden');
                });
            });
            closeBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>

</div>
@endsection