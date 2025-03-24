@extends('layouts.dashboard')

@section('title', 'Plagiarism Reports')

@section('content')
<h2 class="text-2xl font-bold">Plagiarism Reports</h2>

<table class="w-full mt-4 border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">User</th>
            <th class="border p-2">Contest</th>
            <th class="border p-2">Problem</th>
            <th class="border p-2">Plagiarized Code</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($plagiarizedSubmissions as $submission)
        <tr class="border">
            <td class="border p-2">{{ $submission->user->name }}</td>
            <td class="border p-2">{{ $submission->contest->name }}</td>
            <td class="border p-2">{{ $submission->problem->title }}</td>
            <td class="border p-2"><pre>{{ Str::limit($submission->code, 100) }}</pre></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
