@extends('layouts.dashboard')

@section('title', 'Student Dashboard')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <h2 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-gray-600 mt-2">Your personalized coding hub for practice, contests, and performance tracking.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl font-semibold">🚀 Ready to Practice?</h3>
                <a href="{{ route('problems.index') }}" class="mt-4 inline-block bg-white text-green-600 px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                    Start Practicing
                </a>
            </div>
            <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl font-semibold">🏆 Compete in Contests</h3>
                <a href="{{ route('contests.index') }}" class="mt-4 inline-block bg-white text-blue-600 px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                    Check Ongoing Contests
                </a>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
            <h3 class="text-xl font-semibold text-gray-900">📊 Your Submission Stats</h3>
            <div class="flex justify-center mt-4">
                <canvas id="submissionChart" class="w-64 h-64"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('submissionChart').getContext('2d');

        var submissionData = {
            labels: ["Correct Submissions", "Incorrect Submissions"],
            datasets: [{
                data: [{{ auth()->user()->submissions()->where('status', 'Correct')->count() }},
                       {{ auth()->user()->submissions()->where('status', 'Incorrect')->count() }}],
                backgroundColor: ["#4CAF50", "#F44336"],
            }]
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: submissionData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endsection