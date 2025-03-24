<?php

namespace App\Http\Controllers;

use App\Models\ContestSubmission;
use App\Models\Problem;
use Illuminate\Http\Request;
use App\Models\Contest;
use GuzzleHttp\Client;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class ContestSubmissionController extends Controller
{
    public function submit(Request $request, $contestId, $problemId)
    {
        $request->validate(['code' => 'required|string']);

        $problem = Problem::findOrFail($problemId);
        $contest = Contest::findOrFail($contestId);
        $code = $request->code;
        $testCases = $problem->testCases; // Fetch all test cases

        $client = new Client(['verify' => false]); // Temporary SSL fix

        $allPassed = true; // Track if all test cases pass
        $failedCase = null; // Store first failed case details

        foreach ($testCases as $testCase) {
            // JDoodle API Request for each test case
            $response = $client->post(env('JDOODLE_API_URL'), [
                'json' => [
                    'clientId' => env('JDOODLE_CLIENT_ID'),
                    'clientSecret' => env('JDOODLE_CLIENT_SECRET'),
                    'script' => $code,
                    'language' => 'c',
                    'versionIndex' => '5',
                    'stdin' => $testCase->input, // Use test case input
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            $output = trim($result['output'] ?? '');
            $expectedOutput = trim($testCase->expected_output);

            if ($output !== $expectedOutput) {
                $allPassed = false;
                $failedCase = [
                    'input' => $testCase->input,
                    'expected' => $expectedOutput,
                    'actual' => $output,
                ];
                break; // Stop checking after first failed case
            }
        }

        // **🔹 Check for Plagiarism**
        $isPlagiarized = $this->checkPlagiarism($code, $problemId, $contestId);

        $status = $isPlagiarized ? 'Plagiarized' : ($allPassed ? 'Correct' : 'Incorrect');


        // Get elapsed time since contest started
        $elapsedTime = now()->diffInMinutes($contest->start_time);

        // Calculate penalty
        $previousCorrectSubmission = ContestSubmission::where([
            'user_id' => auth()->id(),
            'contest_id' => $contestId,
            'problem_id' => $problemId,
            'status' => 'Correct'
        ])->first();

        $wrongAttempts = ContestSubmission::where([
            'user_id' => auth()->id(),
            'contest_id' => $contestId,
            'problem_id' => $problemId,
            'status' => 'Incorrect'
        ])->count();

        if ($previousCorrectSubmission) {
            $penaltyTime = $previousCorrectSubmission->submission_time - $elapsedTime;
        } else {
            $penaltyTime = $wrongAttempts * 10; // Each incorrect attempt adds 10 minutes
        }

        $penaltyTime = max(0, $penaltyTime);
        $submissionTime = $elapsedTime + $penaltyTime;

        // Save submission with the correct submission time
        ContestSubmission::create([
            'user_id' => auth()->id(),
            'contest_id' => $contestId,
            'problem_id' => $problemId,
            'code' => $code,
            'output' => $failedCase ? $failedCase['actual'] : 'All test cases passed',
            'status' => $status,
            'submission_time' => $submissionTime,
        ]);

        Submission::create([
            'user_id' => auth()->id(),
            'problem_id' => $problem->id,
            'code' => $code,
            'output' => $failedCase ? $failedCase['actual'] : 'All test cases passed',
            'status' => $status,
        ]);
        if ($isPlagiarized) {
            return redirect()->back()->with('status', 'Plagiarized');
        }
        if (!$allPassed) {
            return back()->with([
                'status' => $status,
                'failed_input' => $failedCase['input'],
                'expected_output' => $failedCase['expected'],
                'actual_output' => $failedCase['actual']
            ]);
        }

        return back()->with('status', $status)->with('output', '✅ All test cases passed');
    }
    // **🔹 Function to Check for Plagiarism**
    private function checkPlagiarism($newCode, $problemId, $contestId)
    {
        $existingSubmissions = ContestSubmission::where('problem_id', $problemId)
            ->where('contest_id', $contestId)
            ->where('user_id', '!=', Auth::id()) // Ignore user's own submissions
            ->pluck('code');

        foreach ($existingSubmissions as $existingCode) {
            if ($this->isSimilar($newCode, $existingCode)) {
                return true;
            }
        }
        return false;
    }

    // **🔹 Function to Compare Code Similarity**
    private function isSimilar($code1, $code2)
    {
        similar_text($code1, $code2, $percentage);
        return $percentage >= 85; // Flag as plagiarism if similarity is 85% or more
    }
}
