@extends('layouts.dashboard')

@section('title', 'Create Contest')

@section('content')
<!-- Back Button -->
<div class="-mt-4 mb-6">
    <a href="{{ route('teacher.dashboard') }}"
        class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 
              rounded-lg font-medium text-sm text-white hover:from-indigo-700 hover:to-blue-600 
              focus:outline-none focus:ring-1 focus:ring-indigo-300 transition-all duration-150 
              shadow hover:shadow-lg transform hover:scale-[1.02]">
        <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Dashboard
    </a>
</div>

<div class="container mx-auto p-6 max-w-screen-md">
    <!-- Header -->
    <div class="mb-6 text-center">
        <h2 class="text-4xl font-bold text-gray-900">🚀 Create a New Contest</h2>
        <p class="text-gray-600 mt-2">Set up a contest with problems and time constraints.</p>
    </div>

    <!-- Form -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <form action="{{ route('contests.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Contest Name -->
            <div>
                <label class="block font-semibold text-gray-700">Contest Name:</label>
                <input type="text" name="name" class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-200" required>
            </div>

            <!-- Start Time -->
            <div>
                <label class="block font-semibold text-gray-700">Start Time:</label>
                <input type="datetime-local" name="start_time" class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-200" required>
            </div>

            <!-- End Time -->
            <div>
                <label class="block font-semibold text-gray-700">End Time:</label>
                <input type="datetime-local" name="end_time" class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-200" required>
            </div>

            <!-- Select Problems -->
            <div>
                <label class="block font-semibold text-gray-700">Select Problems:</label>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    @foreach ($problems as $problem)
                    <div class="flex items-center bg-gray-100 p-3 rounded-lg">
                        <input type="checkbox" name="problems[]" value="{{ $problem->id }}" class="mr-2">
                        <label class="text-gray-800">{{ $problem->title }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow-md transition duration-300 transform hover:scale-[1.02]">
                    ✅ Create Contest
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
