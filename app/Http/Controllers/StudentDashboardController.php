<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Problem;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get submission counts
        $submissionCounts = [
            'correct' => $user->submissions()->where('status', 'Correct')->count(),
            'incorrect' => $user->submissions()->where('status', 'Incorrect')->count()
        ];

        // Get difficulty distribution
        $difficultyDistribution = $this->getDifficultyDistribution($user->submissions);

        return view('student.dashboard', [
            'submissionCounts' => $submissionCounts,
            'difficultyDistribution' => $difficultyDistribution
        ]);
    }

    private function getDifficultyDistribution($submissions)
    {
        $solvedProblemIds = $submissions
            ->where('status', 'Correct')
            ->unique('problem_id')
            ->pluck('problem_id');

        $difficulties = Problem::whereIn('id', $solvedProblemIds)
            ->pluck('difficulty');

        $counts = [
            'Easy' => 0,
            'Medium' => 0,
            'Hard' => 0
        ];

        $difficulties->each(function ($difficulty) use (&$counts) {
            if (isset($counts[$difficulty])) {
                $counts[$difficulty]++;
            }
        });

        return $counts;
    }
}