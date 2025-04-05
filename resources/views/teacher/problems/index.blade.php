@extends('layouts.dashboard')

@section('title', 'Manage Problems')

@section('content')
<!-- Back Button -->
<a href="{{ route('problems.index') }}"
        class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 
              rounded-lg font-medium text-sm text-white hover:from-indigo-700 hover:to-blue-600 
              focus:outline-none focus:ring-1 focus:ring-indigo-300 transition-all duration-150 
              shadow hover:shadow-lg transform hover:scale-[1.02] -mt-6">
        <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Problem list
    </a>

<!-- Header & Create Button -->
<div class="flex items-center justify-between mb-6">
    <h2 class="text-3xl font-bold text-gray-800">🛠️ Manage Problems</h2>
    <a href="{{ route('teacher.problems.create') }}"
        class="inline-block bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-semibold px-5 py-2 rounded-lg shadow hover:shadow-md transition transform hover:scale-105">
        ➕ Create Problem
    </a>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 border border-green-300 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<!-- Problem Table -->
<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg shadow-md border border-gray-200">
        <thead class="bg-gray-100 text-gray-700 text-sm font-semibold uppercase">
            <tr>
                <th class="py-3 px-4 text-left">Title</th>
                <th class="py-3 px-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse ($problems as $problem)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="py-3 px-4">{{ $problem->title }}</td>
                <td class="py-3 px-4 text-center space-x-2">
                    <a href="{{ route('teacher.problems.edit', $problem->id) }}"
                        class="inline-block text-sm text-indigo-600 hover:text-indigo-800 font-medium transition">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('teacher.problems.delete', $problem->id) }}" method="POST" class="inline-block"
                          onsubmit="return confirm('Are you sure you want to delete this problem?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-sm text-red-600 hover:text-red-800 font-medium transition">
                            🗑️ Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center py-6 text-gray-500">
                    No problems found. Why not create one?
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
