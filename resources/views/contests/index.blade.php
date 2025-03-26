@extends('layouts.dashboard')

@section('title', 'Contests')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">Contests</h2>

        <!-- Show "Create Contest" Button for Teachers Only -->
        @if (auth()->user()->role === 'teacher')
            <div class="flex justify-center mb-6">
                <a href="{{ route('contests.create') }}"
                   class="bg-gradient-to-r from-purple-500 to-blue-500 hover:from-blue-500 hover:to-purple-500 text-white px-6 py-3 rounded-full shadow-md transition duration-300 transform hover:scale-105">
                    ➕ Create Contest
                </a>
            </div>
        @endif

        @php
            $currentTime = now();
            $ongoing = $contests->filter(fn($c) => $c->start_time <= $currentTime && $c->end_time >= $currentTime);
            $upcoming = $contests->filter(fn($c) => $c->start_time > $currentTime);
            $past = $contests->filter(fn($c) => $c->end_time < $currentTime);
        @endphp

        @foreach (['ongoing' => $ongoing, 'upcoming' => $upcoming, 'past' => $past] as $type => $list)
            @if ($list->count() > 0)
                <h3 class="text-2xl font-bold mt-10 
                    {{ $type === 'ongoing' ? 'text-green-600' : ($type === 'upcoming' ? 'text-blue-600' : 'text-gray-500') }}">
                    {{ $type === 'ongoing' ? '⏳ Ongoing Contests' : ($type === 'upcoming' ? '🚀 Upcoming Contests' : '📅 Past Contests') }}
                </h3>

                <div class="mt-4 space-y-4">
                    @foreach ($list as $contest)
                        <div class="p-5 bg-white rounded-xl shadow-md border border-gray-200 transition hover:shadow-lg hover:border-gray-300">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $contest->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1"><span class="font-medium">Starts:</span> {{ $contest->start_time }}</p>
                            <p class="text-sm text-gray-600"><span class="font-medium">Ends:</span> {{ $contest->end_time }}</p>

                            <div class="mt-3">
                                <a href="{{ route('contests.show', $contest->id) }}" 
                                   class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300">
                                    🔍 View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
@endsection
