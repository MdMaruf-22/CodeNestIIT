@extends('layouts.dashboard')

@section('title', 'Plagiarism Reports')

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
<div class="space-y-6">

    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900">🚨 Plagiarism Reports</h2>
        <p class="text-gray-500 mt-2">Review suspected cases of code duplication across contests and problems.</p>
    </div>

    <div class="overflow-x-auto">
        <div class="shadow-lg rounded-2xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">User</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Contest</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Problem</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Plagiarized Code</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($plagiarizedSubmissions as $submission)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $submission->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $submission->contest->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $submission->problem->title }}</td>
                            <td class="px-6 py-4 text-sm font-mono text-gray-600 whitespace-pre-line bg-gray-50 rounded-md max-w-2xl overflow-auto">
                                <code>{{ Str::limit($submission->code, 300) }}</code>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">No plagiarism reports found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
