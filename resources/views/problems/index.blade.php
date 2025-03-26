@extends('layouts.dashboard')

@section('title', 'Problem Repository')

@section('content')
<div class="p-6">
    <h2 class="text-3xl font-bold text-gray-800">🚀 Problem Repository</h2>
    <p class="text-gray-600">Browse and solve programming challenges across different difficulty levels.</p>

    <!-- Filter Section -->
    <div class="mt-4">
        <p class="text-gray-500 italic">🔍 Use filters to find problems easily!</p>
        <div class="mt-2 flex space-x-3">
            <button onclick="filterProblems('all')" class="filter-btn bg-gray-200 hover:bg-gray-300">All</button>
            <button onclick="filterProblems('Easy')" class="filter-btn bg-green-200 hover:bg-green-300">Easy</button>
            <button onclick="filterProblems('Medium')" class="filter-btn bg-yellow-200 hover:bg-yellow-300">Medium</button>
            <button onclick="filterProblems('Hard')" class="filter-btn bg-red-200 hover:bg-red-300">Hard</button>
        </div>
    </div>

    <!-- Problem List -->
    <div id="problemList" class="mt-6 space-y-4">
        @foreach ($problems as $problem)
            <div class="problem-item p-5 bg-white rounded-lg shadow-md border-l-4 
                @if($problem->difficulty === 'Easy') border-green-500
                @elseif($problem->difficulty === 'Medium') border-yellow-500
                @else border-red-500 @endif"
                data-difficulty="{{ $problem->difficulty }}">

                <div class="flex items-center justify-between">
                    <!-- Problem Title -->
                    <a href="{{ route('problems.show', $problem->id) }}" 
                        class="text-lg font-semibold text-blue-600 hover:underline">
                        {{ $problem->title }}
                    </a>

                    <!-- Difficulty Badge -->
                    <span class="px-3 py-1 text-sm font-semibold rounded-full text-white 
                        @if($problem->difficulty === 'Easy') bg-green-500
                        @elseif($problem->difficulty === 'Medium') bg-yellow-500
                        @else bg-red-500 @endif">
                        {{ $problem->difficulty }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- JavaScript for Filtering -->
<script>
    function filterProblems(difficulty) {
        document.querySelectorAll('.problem-item').forEach(item => {
            if (difficulty === 'all' || item.getAttribute('data-difficulty') === difficulty) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>

<!-- Tailwind Button Styling -->
<style>
    .filter-btn {
        @apply px-4 py-2 rounded text-gray-800 font-semibold transition;
    }
</style>
@endsection
