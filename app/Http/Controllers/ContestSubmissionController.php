<?php

namespace App\Http\Controllers;

use App\Models\ContestSubmission;
use App\Models\Problem;
use Illuminate\Http\Request;
use App\Models\Contest;
use GuzzleHttp\Client;
use App\Models\Submission;

class ContestSubmissionController extends Controller
{
    public function submit(Request $request, $contestId, $problemId)
    {
        $request->validate(['code' => 'required|string']);

        $problem = Problem::findOrFail($problemId);
        $contest = Contest::findOrFail($contestId);
        $code = $request->code;

        // Check if user has previously solved this problem correctly
        $previousCorrectSubmission = ContestSubmission::where([
            'user_id' => auth()->id(),
            'contest_id' => $contestId,
            'problem_id' => $problemId,
            'status' => 'Correct'
        ])->first();

        // Count previous incorrect attempts before solving correctly
        $wrongAttempts = ContestSubmission::where([
            'user_id' => auth()->id(),
            'contest_id' => $contestId,
            'problem_id' => $problemId,
            'status' => 'Incorrect'
        ])->count();

        // Execute code via JDoodle
        $client = new Client(['verify' => false]);
        $response = $client->post(env('JDOODLE_API_URL'), [
            'json' => [
                'clientId' => env('JDOODLE_CLIENT_ID'),
                'clientSecret' => env('JDOODLE_CLIENT_SECRET'),
                'script' => $code,
                'language' => 'c',
                'versionIndex' => '5',
                'stdin' => $problem->sample_input,
            ],
        ]);

        $result = json_decode($response->getBody(), true);
        $output = trim($result['output'] ?? '');
        $expectedOutput = trim($problem->sample_output);
        $status = ($output === $expectedOutput) ? 'Correct' : 'Incorrect';

        // Get elapsed time since contest started
        $elapsedTime = now()->diffInMinutes($contest->start_time);

        // If problem was solved before, keep the penalty same as first correct submission
        if ($previousCorrectSubmission) {
            $penaltyTime = $previousCorrectSubmission->submission_time - $elapsedTime;
        } else {
            // Otherwise, calculate new penalty
            $penaltyTime = $wrongAttempts * 10; // Each incorrect attempt adds 10 minutes
        }

        // Ensure penalty is never negative
        $penaltyTime = max(0, $penaltyTime);

        // Total submission time including penalties
        $submissionTime = $elapsedTime + $penaltyTime;

        // Save submission with the correct submission time
        ContestSubmission::create([
            'user_id' => auth()->id(),
            'contest_id' => $contestId,
            'problem_id' => $problemId,
            'code' => $code,
            'output' => $output,
            'status' => $status,
            'submission_time' => $submissionTime,
        ]);
        Submission::create([
            'user_id' => auth()->id(),
            'problem_id' => $problem->id,
            'code' => $code,
            'output' => $output,
            'status' => $status,
        ]);
        return back()->with('status', $status)->with('output', $output);
    }
}