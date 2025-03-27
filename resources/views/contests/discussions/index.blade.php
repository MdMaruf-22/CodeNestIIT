@extends('layouts.dashboard')

@section('title', $contest->name . ' - Discussion')

@section('content')
<!-- Back Button -->
<div class="-mt-4 mb-6">
    <a href="{{ route('contests.show', $contest) }}"
        class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 
              rounded-lg font-medium text-sm text-white hover:from-indigo-700 hover:to-blue-600 
              focus:outline-none focus:ring-1 focus:ring-indigo-300 transition-all duration-150 
              shadow hover:shadow-lg transform hover:scale-[1.02]">
        <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Contests
    </a>
</div>
<div class="container mx-auto p-6 max-w-screen-md">
    <!-- Header -->
    <div class="mb-6 text-center">
        <h2 class="text-4xl font-bold text-gray-900">💬 {{ $contest->name }} - Discussion Forum</h2>
        <p class="text-gray-600 mt-2">Discuss problems about problems.</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <p class="text-green-600 text-center font-semibold">{{ session('success') }}</p>
    @endif

    <!-- Post a New Comment -->
    @if(auth()->check())
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <form action="{{ route('contests.discussions.store', $contest->id) }}" method="POST" class="space-y-3">
            @csrf
            <textarea name="content" rows="3" class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-200" 
                      placeholder="Ask a question or share something..."></textarea>
            <button type="submit" class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold 
                    rounded-lg shadow-md transition duration-300 transform hover:scale-[1.02]">
                🚀 Post Discussion
            </button>
        </form>
    </div>
    @else
    <p class="text-gray-600 text-center">You must be logged in to comment.</p>
    @endif

    <!-- Discussion Threads -->
    <div class="space-y-6">
        @foreach ($discussions as $discussion)
        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
            <p class="font-semibold text-indigo-700">{{ $discussion->user->name }}</p>
            <p class="text-gray-800">{{ $discussion->content }}</p>
            <p class="text-sm text-gray-500">{{ $discussion->created_at->diffForHumans() }}</p>

            <!-- Replies Section -->
            <div class="mt-3 space-y-3 border-l-4 border-indigo-500 pl-4">
                @foreach ($discussion->replies as $reply)
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <p class="font-semibold text-blue-700">{{ $reply->user->name }}</p>
                    <p class="text-gray-800">{{ $reply->content }}</p>
                    <p class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                </div>
                @endforeach

                <!-- Reply Form -->
                @if(auth()->check())
                <form action="{{ route('contests.discussions.store', $contest->id) }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $discussion->id }}">
                    <textarea name="content" rows="2" class="w-full p-2 border rounded-lg focus:ring focus:ring-indigo-200" 
                              placeholder="Reply to this comment..."></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg 
                            hover:bg-blue-600 transition duration-200">
                        ➡ Reply
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
