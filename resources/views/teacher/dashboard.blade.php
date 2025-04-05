@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="space-y-8">

    <div class="text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2 animate-fade-up">Welcome, Teacher!</h2>
        <p class="text-gray-500 text-lg animate-fade-up animate-delay-100">Effortlessly manage contests, problems & evaluate submissions.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6">

        <!-- Contest Management -->
        <div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow hover:shadow-lg transition animate-fade-up">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10m-12 4h14m-8 4h2" />
                    </svg>
                    Contest Management
                </h3>
            </div>
            <div class="space-y-3">
                <a href="{{ route('contests.create') }}"
                   class="w-full block text-center py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition">Create Contest</a>
                <a href="{{ route('teacher.contests') }}"
                   class="w-full block text-center py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">Manage Contests</a>
            </div>
        </div>

        <!-- Problem Management -->
        <div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow hover:shadow-lg transition animate-fade-up animate-delay-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Problem Management
                </h3>
            </div>
            <div class="space-y-3">
                <a href="{{ route('teacher.problems.create') }}"
                   class="w-full block text-center py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition">Create Problem</a>
                <a href="{{ route('teacher.problems') }}"
                   class="w-full block text-center py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">Manage Problems</a>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow hover:shadow-lg transition animate-fade-up">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                    Pending Requests
                </h3>
            </div>
            <a href="{{ route('teacher.approvals') }}"
               class="w-full block text-center py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition">See Pending Requests</a>
        </div>

        <!-- Plagiarism Reports -->
        <div class="group bg-white p-6 rounded-2xl border border-gray-100 shadow hover:shadow-lg transition animate-fade-up animate-delay-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m2 7H7a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v9a2 2 0 01-2 2z" />
                    </svg>
                    Plagiarism Reports
                </h3>
            </div>
            <a href="{{ route('teacher.plagiarism_reports') }}"
               class="w-full block text-center py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">See Reports</a>
        </div>

    </div>
</div>
@endsection

@section('styles')
<style>
@keyframes fade-up {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-up {
  animation: fade-up 0.6s ease-out both;
}

.animate-delay-100 {
  animation-delay: 0.1s;
}
</style>
@endsection
