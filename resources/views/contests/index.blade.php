@extends('layouts.dashboard')

@section('title', 'Contests')

@section('content')
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-8 text-center">
            🏆 Contests
        </h2>

        <!-- Show "Create Contest" Button for Teachers Only -->
        @if (auth()->user()->role === 'teacher')
            <div class="flex justify-center mb-8">
                <a href="{{ route('contests.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg font-semibold transition-transform transform hover:scale-105 flex items-center gap-2">
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

        @foreach (['ongoing' => $ongoing, 'upcoming' => $upcoming, 'ended' => $past] as $type => $list)
            @if ($list->count() > 0)
                <h3 class="text-2xl font-bold mt-12 mb-4 border-l-4 pl-4 
                    {{ $type === 'ongoing' ? 'text-green-600 border-green-600' : ($type === 'upcoming' ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-gray-400') }}">
                    {{ $type === 'ongoing' ? '⏳ Ongoing Contests' : ($type === 'upcoming' ? '🚀 Upcoming Contests' : '📅 Past Contests') }}
                </h3>

                <div class="grid gap-6">
                    @foreach ($list as $contest)
                        <div class="p-6 bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl hover:border-gray-300 transition duration-300">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $contest->name }}</h3>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $type === 'ongoing' ? 'bg-green-100 text-green-600' : ($type === 'upcoming' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600') }}">
                                    {{ ucfirst($type) }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mt-2"><span class="font-medium">📅 Starts:</span> {{ $contest->start_time }}</p>
                            <p class="text-sm text-gray-600"><span class="font-medium">⏳ Ends:</span> {{ $contest->end_time }}</p>

                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('contests.show', $contest->id) }}" 
                                   class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105 flex items-center gap-2">
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
