@extends('layouts.dashboard')

@section('title', 'User Approvals')

@section('content')
<a href="{{ route('teacher.dashboard') }}"
    class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 
           rounded-lg font-medium text-sm text-white hover:from-indigo-700 hover:to-blue-600 
           focus:outline-none focus:ring-1 focus:ring-indigo-300 transition-all duration-150 
           shadow hover:shadow-lg transform hover:scale-[1.02] mb-6">
    <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
         xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
              d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back to Dashboard
</a>
<!-- Page Header -->
<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-semibold text-gray-800">⏳ Pending User Approvals</h2>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 border border-green-300 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<!-- User Approvals Table -->
<div class="overflow-x-auto shadow-lg rounded-lg border border-gray-300 bg-white">
    <table class="min-w-full bg-white rounded-lg">
        <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
            <tr class="text-sm font-medium">
                <th class="py-3 px-4 text-left">Name</th>
                <th class="py-3 px-4 text-left">Email</th>
                <th class="py-3 px-4 text-left">Role</th>
                <th class="py-3 px-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @foreach ($pendingUsers as $user)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="py-3 px-4">{{ $user->name }}</td>
                <td class="py-3 px-4">{{ $user->email }}</td>
                <td class="py-3 px-4">{{ ucfirst($user->role) }}</td>
                <td class="py-3 px-4 text-center">
                    <!-- Approve Button -->
                    <form action="{{ route('teacher.approve', $user->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" 
                            class="flex items-center justify-center px-4 py-2 bg-gradient-to-r from-green-400 to-green-500 text-white rounded-lg hover:bg-gradient-to-r hover:from-green-500 hover:to-green-600 shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300 transition-all">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Approve
                        </button>
                    </form>

                    <!-- Reject Button -->
                    <form action="{{ route('teacher.reject', $user->id) }}" method="POST" class="inline-block ml-2">
                        @csrf
                        <button type="submit" 
                            class="flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-400 to-red-500 text-white rounded-lg hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 shadow-lg focus:outline-none focus:ring-2 focus:ring-red-300 transition-all">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 6L6 18"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12"></path>
                            </svg>
                            Reject
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
