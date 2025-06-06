<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ContestSubmission;
use App\Models\Contest;
use App\Models\Submission;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    //
    public function show(User $user)
    {
        // Fetch all contest submissions
        $submissions = ContestSubmission::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Count unique problems solved
        $solvedProblems = Submission::where('user_id', $user->id)
            ->where('status', 'Correct')
            ->distinct('problem_id')
            ->count();

        // Get contests participated in by user
        $contestsParticipated = ContestSubmission::where('user_id', $user->id)
            ->distinct('contest_id')
            ->pluck('contest_id');

        $contests = Contest::whereIn('id', $contestsParticipated)->get();

        // Count problems solved per contest
        $contestsWithSolvedCount = $contests->map(function ($contest) use ($user) {
            $solvedCount = ContestSubmission::where('user_id', $user->id)
                ->where('contest_id', $contest->id)
                ->where('status', 'Correct')
                ->distinct('problem_id')
                ->count();

            return [
                'contest' => $contest,
                'solvedCount' => $solvedCount,
            ];
        });
        // Fetch all submissions from the submission table (all submissions, not only contest-related)
        $allSubmissions = Submission::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // Get the total number of submissions for the user (without pagination)
        $totalAttempts = Submission::where('user_id', $user->id)->count();
        // Get the correct submissions for the user
        $correctSubmissions = Submission::where('user_id', $user->id)
            ->where('status', 'correct')
            ->count();
        return view('profile.show', compact('user', 'submissions', 'solvedProblems', 'contestsWithSolvedCount', 'allSubmissions', 'totalAttempts','correctSubmissions'));
    }
}
