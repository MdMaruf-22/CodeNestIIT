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

        // JDoodle API Request
        $client = new Client(['verify' => false]); // Temporary SSL fix
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

        // Save Submission
        Submission::create([
            'user_id' => Auth::id(),
            'problem_id' => $problem->id,
            'code' => $code,
            'output' => $output,
            'status' => $status,
        ]);

        return back()->with('status', $status)->with('output', $output);
    }
}
