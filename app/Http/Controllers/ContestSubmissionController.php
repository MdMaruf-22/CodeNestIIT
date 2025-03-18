<?php

namespace App\Http\Controllers;

use App\Models\ContestSubmission;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class ContestSubmissionController extends Controller
{
    public function submit(Request $request, $contestId, $problemId)
    {
        $request->validate(['code' => 'required|string']);

        $problem = Problem::findOrFail($problemId);
        $code = $request->code;

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
        $status = ($output === trim($problem->sample_output)) ? 'Correct' : 'Incorrect';

        // Save submission
        ContestSubmission::create([
            'user_id' => Auth::id(),
            'contest_id' => $contestId,
            'problem_id' => $problemId,
            'code' => $code,
            'output' => $output,
            'status' => $status,
        ]);

        return back()->with('status', $status)->with('output', $output);
    }
}