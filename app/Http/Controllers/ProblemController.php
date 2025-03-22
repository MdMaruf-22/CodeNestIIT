<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;


class ProblemController extends Controller
{
    //
    // Display all problems
    public function index()
    {
        $problems = Problem::all();
        return view('problems.index', compact('problems'));
    }

    // Show a single problem
    public function show($id)
    {
        $problem = Problem::findOrFail($id);
        return view('problems.show', compact('problem'));
    }
    //Submitting the code
    public function submit(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $problem = Problem::findOrFail($id);
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

        $status = $allPassed ? 'Correct' : 'Incorrect';

        // Save Submission
        Submission::create([
            'user_id' => Auth::id(),
            'problem_id' => $problem->id,
            'code' => $code,
            'output' => $failedCase ? $failedCase['actual'] : 'All test cases passed',
            'status' => $status,
        ]);

        if (!$allPassed) {
            return back()->with([
                'status' => $status,
                'failed_input' => $failedCase['input'],
                'expected_output' => $failedCase['expected'],
                'actual_output' => $failedCase['actual']
            ]);
        }


        return back()->with('status', $status)
            ->with('output', '✅ All test cases passed');
    }
    public function runCustom(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string',
            'input' => 'nullable|string'
        ]);

        $problem = Problem::findOrFail($id);
        $client = new Client(['verify' => false]);

        $response = $client->post(env('JDOODLE_API_URL'), [
            'json' => [
                'clientId' => env('JDOODLE_CLIENT_ID'),
                'clientSecret' => env('JDOODLE_CLIENT_SECRET'),
                'script' => $request->code,
                'language' => 'c',
                'versionIndex' => '5',
                'stdin' => $request->input,
            ],
        ]);

        $result = json_decode($response->getBody(), true);
        return response()->json(['output' => trim($result['output'] ?? 'Error running code')]);
    }
}
