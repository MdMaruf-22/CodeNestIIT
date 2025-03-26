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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Submission Accuracy Chart -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900">📊 Submission Accuracy</h3>
                <div class="flex justify-center mt-4">
                    <canvas id="submissionChart" class="w-64 h-64"></canvas>
                </div>
            </div>

            <!-- Difficulty Distribution Chart -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900">📈 Solved Problems Difficulty</h3>
                <div class="flex justify-center mt-4">
                    <canvas id="difficultyChart" class="w-64 h-64"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Submission Accuracy Chart
        const submissionCtx = document.getElementById('submissionChart').getContext('2d');
        new Chart(submissionCtx, {
            type: 'doughnut',
            data: {
                labels: ["Correct Submissions", "Incorrect Submissions"],
                datasets: [{
                    data: [
                        {{ $submissionCounts['correct'] }},
                        {{ $submissionCounts['incorrect'] }}
                    ],
                    backgroundColor: ["#4CAF50", "#F44336"],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Difficulty Distribution Chart
        const difficultyCtx = document.getElementById('difficultyChart').getContext('2d');
        new Chart(difficultyCtx, {
            type: 'pie',
            data: {
                labels: ["Easy", "Medium", "Hard"],
                datasets: [{
                    data: [
                        {{ $difficultyDistribution['Easy'] }},
                        {{ $difficultyDistribution['Medium'] }},
                        {{ $difficultyDistribution['Hard'] }}
                    ],
                    backgroundColor: ["#4CAF50", "#FFC107", "#F44336"],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw} problems`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection