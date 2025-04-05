@extends('layouts.dashboard')

@section('title', 'Manage Contests')

@section('content')
<div class="space-y-8">
    
    <div class="text-center">
        <h2 class="text-4xl font-bold text-gray-900">🎯 Manage Contests</h2>
        <p class="text-gray-500 mt-2">Create, edit, and oversee your active and upcoming contests.</p>
        <a href="{{ route('contests.create') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-xl shadow-md hover:from-blue-700 hover:to-indigo-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Create Contest
        </a>
    </div>

    @if(session('success'))
        <div class="max-w-2xl mx-auto">
            <div class="bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-lg text-center">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="overflow-x-auto max-w-7xl mx-auto bg-white shadow-xl rounded-2xl">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 tracking-wider">Start Time</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 tracking-wider">End Time</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($contests as $contest)
                    <tr class="hover:bg-gray-50 transition duration-300">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $contest->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($contest->start_time)->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($contest->end_time)->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('teacher.contests.edit', $contest->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold transition duration-200">Edit</a>
                                <form action="{{ route('teacher.contests.delete', $contest->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contest?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition duration-200">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">No contests available yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
