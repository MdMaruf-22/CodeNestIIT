<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contest;
use App\Models\Problem;
use App\Models\TestCase;
use App\Models\User;
use App\Models\ContestSubmission;

class TeacherController extends Controller
{
    //
    public function manageContests()
    {
        $contests = Contest::all();
        return view('teacher.contests.index', compact('contests'));
    }

    public function manageProblems()
    {
        $problems = Problem::all();
        return view('teacher.problems.index', compact('problems'));
    }

    public function createContest()
    {
        return view('teacher.contests.create');
    }

    public function storeContest(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        Contest::create($request->all());

        return redirect()->route('teacher.contests')->with('success', 'Contest created successfully.');
    }

    public function editContest(Contest $contest)
    {
        return view('teacher.contests.edit', compact('contest'));
    }

    public function updateContest(Request $request, Contest $contest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $contest->update($request->all());

        return redirect()->route('teacher.contests')->with('success', 'Contest updated successfully.');
    }

    public function deleteContest(Contest $contest)
    {
        $contest->delete();
        return redirect()->route('teacher.contests')->with('success', 'Contest deleted.');
    }

    public function createProblem()
    {
        return view('teacher.problems.create');
    }

    public function storeProblem(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'input_format' => 'required|string',
            'output_format' => 'required|string',
            'sample_input' => 'required|string',
            'sample_output' => 'required|string',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'tags' => 'nullable|string',
            'editorial' => 'nullable|string',
            'hint' => 'nullable|string'
        ]);

        Problem::create($request->all());

        return redirect()->route('teacher.problems')->with('success', 'Problem created successfully.');
    }

    public function editProblem(Problem $problem)
    {
        return view('teacher.problems.edit', compact('problem'));
    }

    public function updateProblem(Request $request, Problem $problem)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'input_format' => 'required|string',
            'output_format' => 'required|string',
            'sample_input' => 'required|string',
            'sample_output' => 'required|string',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'tags' => 'nullable|string',
            'editorial' => 'nullable|string',
            'hint' => 'nullable|string'
        ]);

        $problem->update($request->all());

        return redirect()->route('teacher.problems')->with('success', 'Problem updated successfully.');
    }

    public function deleteProblem(Problem $problem)
    {
        $problem->delete();
        return redirect()->route('teacher.problems')->with('success', 'Problem deleted.');
    }
    public function manageTestCases(Problem $problem)
    {
        return view('teacher.problems.test_cases', compact('problem'));
    }

    public function storeTestCase(Request $request, Problem $problem)
    {
        $request->validate([
            'input' => 'required|string',
            'expected_output' => 'required|string',
            'is_sample' => 'boolean'
        ]);

        TestCase::create([
            'problem_id' => $problem->id,
            'input' => $request->input,
            'expected_output' => $request->expected_output,
            'is_sample' => $request->has('is_sample')
        ]);

        return back()->with('success', 'Test case added successfully.');
    }

    public function deleteTestCase(TestCase $testCase)
    {
        $testCase->delete();
        return back()->with('success', 'Test case removed.');
    }
    public function showApprovals()
    {
        $pendingUsers = User::where('is_approved', false)->get();
        return view('teacher.approvals', compact('pendingUsers'));
    }

    public function approveUser(User $user)
    {
        $user->update(['is_approved' => true]);
        return redirect()->route('teacher.approvals')->with('success', 'User approved successfully.');
    }

    public function rejectUser(User $user)
    {
        $user->delete();
        return redirect()->route('teacher.approvals')->with('success', 'User rejected.');
    }
    public function plagiarismReports()
{
    $plagiarizedSubmissions = ContestSubmission::where('status', 'Plagiarized')
        ->with('user', 'problem', 'contest')
        ->get();

    return view('teacher.plagiarism_reports', compact('plagiarizedSubmissions'));
}

}
