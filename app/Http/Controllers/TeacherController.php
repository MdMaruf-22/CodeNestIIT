<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contest;
use App\Models\Problem;

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
        ]);

        $problem->update($request->all());

        return redirect()->route('teacher.problems')->with('success', 'Problem updated successfully.');
    }

    public function deleteProblem(Problem $problem)
    {
        $problem->delete();
        return redirect()->route('teacher.problems')->with('success', 'Problem deleted.');
    }
}
