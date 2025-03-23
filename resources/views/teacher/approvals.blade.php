@extends('layouts.dashboard')

@section('title', 'User Approvals')

@section('content')
<h2 class="text-2xl font-bold">Pending User Approvals</h2>

@if(session('success'))
<p class="text-green-500">{{ session('success') }}</p>
@endif

<table class="w-full mt-4 border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Name</th>
            <th class="border p-2">Email</th>
            <th class="border p-2">Role</th>
            <th class="border p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pendingUsers as $user)
        <tr class="border">
            <td class="border p-2">{{ $user->name }}</td>
            <td class="border p-2">{{ $user->email }}</td>
            <td class="border p-2">{{ ucfirst($user->role) }}</td>
            <td class="border p-2">
                <form action="{{ route('teacher.approve', $user->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded">Approve</button>
                </form>
                <form action="{{ route('teacher.reject', $user->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Reject</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
