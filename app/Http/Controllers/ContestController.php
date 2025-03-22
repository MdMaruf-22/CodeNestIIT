<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Submission;
use GuzzleHttp\Client;
use App\Models\ContestSubmission;

class ContestController extends Controller
{
    //
    // Display all contests
    public function index()
    {
        $contests = Contest::all();
        return view('contests.index', compact('contests'));
    }

    // Show contest creation form
    public function create()
    {
        $problems = Problem::all();
        return view('contests.create', compact('problems'));
    }

    // Store new contest
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'problems' => 'required|array',
        ]);

        $contest = Contest::create([
            'name' => $request->name,
            'teacher_id' => Auth::id(),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        // Attach problems to contest
        $contest->problems()->attach($request->problems);

        return redirect()->route('contests.index')->with('success', 'Contest created successfully!');
    }
    public function show(Contest $contest)
    {
        return view('contests.show', compact('contest'));
    }
    public function solve(Contest $contest, $problemId)
    {
        $problem = $contest->problems()->findOrFail($problemId);
        return view('contests.solve', compact('contest', 'problem'));
    }

    public function submitSolution(Request $request, $contest_id, $problem_id)
    {
        $request->validate(['code' => 'required|string']);

        $contest = Contest::findOrFail($contest_id);
        $problem = $contest->problems()->findOrFail($problem_id);
        $code = $request->code;

        // Execute Code Using JDoodle
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
            'user_id' => auth()->id(),
            'problem_id' => $problem->id,
            'code' => $code,
            'output' => $output,
            'status' => $status,
        ]);

        return back()->with('status', $status)->with('output', $output);
    }
    public function leaderboard(Contest $contest)
    {
        $leaderboard = ContestSubmission::where('contest_submissions.contest_id', $contest->id)
            ->where('contest_submissions.status', 'Correct')
            ->join('contest_problems', function ($join) {
                $join->on('contest_submissions.problem_id', '=', 'contest_problems.problem_id')
                    ->on('contest_submissions.contest_id', '=', 'contest_problems.contest_id');
            })
            ->selectRaw('
            contest_submissions.user_id,
            SUM(contest_problems.score) as total_score,
            MAX(contest_submissions.submission_time) as last_solved_time,
            COUNT(DISTINCT contest_submissions.problem_id) as correct_submissions
        ')
            ->whereRaw('contest_submissions.id IN (
            SELECT MIN(sub_time.id) FROM contest_submissions AS sub_time
            WHERE sub_time.user_id = contest_submissions.user_id
            AND sub_time.problem_id = contest_submissions.problem_id
            AND sub_time.contest_id = contest_submissions.contest_id
            AND sub_time.status = "Correct"
            GROUP BY sub_time.user_id, sub_time.problem_id, sub_time.contest_id
        )')
            ->groupBy('contest_submissions.user_id')
            ->orderByDesc('total_score')
            ->orderBy('last_solved_time')
            ->get();

        return view('contests.leaderboard', compact('contest', 'leaderboard'));
    }
    public function results(Contest $contest)
{
    if (now()->lessThan($contest->end_time)) {
        return redirect()->route('contests.show', $contest->id)->with('error', 'Results will be available after the contest ends.');
    }

    $leaderboard = ContestSubmission::where('contest_submissions.contest_id', $contest->id)
        ->where('contest_submissions.status', 'Correct')
        ->join('contest_problems', function ($join) {
            $join->on('contest_submissions.problem_id', '=', 'contest_problems.problem_id')
                ->on('contest_submissions.contest_id', '=', 'contest_problems.contest_id');
        })
        ->selectRaw('
            contest_submissions.user_id,
            SUM(contest_problems.score) as total_score,
            MAX(contest_submissions.submission_time) as last_solved_time,
            COUNT(DISTINCT contest_submissions.problem_id) as correct_submissions
        ')
        ->whereRaw('contest_submissions.id IN (
            SELECT MIN(sub_time.id) FROM contest_submissions AS sub_time
            WHERE sub_time.user_id = contest_submissions.user_id
            AND sub_time.problem_id = contest_submissions.problem_id
            AND sub_time.contest_id = contest_submissions.contest_id
            AND sub_time.status = "Correct"
            GROUP BY sub_time.user_id, sub_time.problem_id, sub_time.contest_id
        )')
        ->groupBy('contest_submissions.user_id')
        ->orderByDesc('total_score')
        ->orderBy('last_solved_time')
        ->get();

    return view('contests.results', compact('contest', 'leaderboard'));
}

}
