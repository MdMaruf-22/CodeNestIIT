@extends('layouts.dashboard')

@section('title', $contest->name . ' - Discussion')

@section('content')
<h2 class="text-2xl font-bold">{{ $contest->name }} - Discussion Forum</h2>

@if(session('success'))
<p class="text-green-600">{{ session('success') }}</p>
@endif

<!-- Post a New Comment -->
@if(auth()->check())
<form action="{{ route('contests.discussions.store', $contest->id) }}" method="POST" class="mt-4">
    @csrf
    <textarea name="content" rows="3" class="w-full p-2 border rounded" placeholder="Ask a question or share something..."></textarea>
    <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Post</button>
</form>
@else
<p class="text-gray-600 mt-2">You must be logged in to comment.</p>
@endif

<!-- Discussion Threads -->
<ul class="mt-4">
    @foreach ($discussions as $discussion)
    <li class="border-b p-2">
        <p class="font-semibold">{{ $discussion->user->name }}</p>
        <p>{{ $discussion->content }}</p>
        <p class="text-sm text-gray-500">{{ $discussion->created_at->diffForHumans() }}</p>

        <!-- Show Replies -->
        <ul class="mt-2 ml-6">
            @foreach ($discussion->replies as $reply)
            <li class="border-l-2 pl-2">
                <p class="font-semibold">{{ $reply->user->name }}</p>
                <p>{{ $reply->content }}</p>
                <p class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
            </li>
            @endforeach

            <!-- Reply Button (After Last Reply) -->
            @if(auth()->check())
            <li class="mt-2">
                <form action="{{ route('contests.discussions.store', $contest->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $discussion->id }}">
                    <textarea name="content" rows="2" class="w-full p-2 border rounded" placeholder="Reply to this comment..."></textarea>
                    <button type="submit" class="mt-1 px-3 py-1 bg-blue-500 text-white rounded">Reply</button>
                </form>
            </li>
            @endif
        </ul>
    </li>
    @endforeach
</ul>
@endsection
