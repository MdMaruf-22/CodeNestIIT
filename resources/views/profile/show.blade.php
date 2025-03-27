@extends('layouts.dashboard')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="p-6 space-y-6">
    <!-- Profile Header -->
    <div class="relative bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-8 rounded-2xl shadow-2xl overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: url('/images/grid.svg');"></div>
        <div class="relative z-10 flex items-center space-x-6">
            <div class="flex-shrink-0">
                <div class="h-20 w-20 rounded-full bg-white/10 flex items-center justify-center text-3xl">
                    👤
                </div>
            </div>
            <div>
                <h1 class="text-4xl font-bold">{{ $user->name }}</h1>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Solved Problems</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $solvedProblems }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Contests Joined</p>
                    <p class="text-3xl font-bold text-gray-800">{{ count($contestsWithSolvedCount) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
            <p class="text-gray-500">Accuracy</p>
            <p class="text-3xl font-bold text-gray-800">
                @php
                $accuracy = $totalAttempts > 0 ? round(($correctSubmissions / $totalAttempts) * 100) : 0;
                @endphp
                {{ $accuracy }}%
            </p>
        </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Contests Section -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
    <h3 class="text-xl font-semibold mb-6 flex items-center">
        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        Contest History
    </h3>

    <div class="space-y-4">
        @forelse ($contestsWithSolvedCount as $contestData)
        <div class="group p-4 rounded-lg border border-gray-200 hover:border-purple-200 hover:bg-purple-50 transition-colors">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('contests.show', $contestData['contest']->id) }}" 
                       class="font-semibold text-gray-800 hover:text-purple-600 transition-colors block">
                        {{ $contestData['contest']->name }}
                    </a>
                    <div class="mt-1">
                        <a href="{{ route('contests.show', $contestData['contest']->id) }}" 
                           class="text-purple-600 hover:text-purple-700 text-sm inline-flex items-center">
                            View Contest
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        {{ $contestData['solvedCount'] }}
                    </div>
                    <div class="text-xs text-gray-500">SOLVED</div>
                </div>
            </div>
            <div class="mt-3">
                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-500 transition-all duration-500"
                        style="width: {{ ($contestData['solvedCount'] / max(1, $contestData['contest']->problems->count())) * 100 }}%">
                    </div>
                </div>
                <div class="text-xs text-gray-500 mt-1 text-right">
                    {{ $contestData['contest']->problems->count() }} problems total
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            No contest participation yet
        </div>
        @endforelse
    </div>
</div>

        <!-- Recent Submissions -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <h3 class="text-xl font-semibold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Recent Submissions
            </h3>

            <div class="space-y-4">
                @forelse ($allSubmissions->take(5) as $submission)
                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-green-200 hover:bg-green-50 transition-colors">
                    <div>
                        <a href="{{ route('problems.show', $submission->problem->id) }}"
                            class="font-medium text-gray-800 hover:text-green-600 transition-colors">
                            {{ $submission->problem->title }}
                        </a>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $submission->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-2 py-1 text-sm rounded-full {{ $submission->status === 'Correct' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $submission->status }}
                        </span>
                        <button class="text-gray-400 hover:text-green-600 view-code"
                            data-code="{{ htmlspecialchars($submission->code) }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    No submissions yet
                </div>
                @endforelse
            </div>

            @if($allSubmissions->count() > 5)
            <div class="mt-6 text-center">
                <a href="#all-submissions" class="text-purple-600 hover:text-purple-700 font-medium">
                    View All Submissions ↓
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- All Submissions Section -->
    <div id="all-submissions" class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
        <h3 class="text-xl font-semibold mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            All Submissions
        </h3>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Problem</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Time</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Code</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($allSubmissions as $submission)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <a href="{{ route('problems.show', $submission->problem->id) }}"
                                class="text-blue-600 hover:text-blue-700">
                                {{ $submission->problem->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-sm rounded-full {{ $submission->status === 'Correct' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $submission->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $submission->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-700 view-code"
                                data-code="{{ htmlspecialchars($submission->code) }}">
                                View Code
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $allSubmissions->links() }}
        </div>
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
        hljs.configure({
            cssSelector: '#modalCodeContent',
            languages: ['c', 'cpp', 'python', 'java'],
        });
    </script>

</div>
@endsection