<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContestDiscussion;
use App\Models\Contest;


class ContestDiscussionController extends Controller
{
    //
    public function index($contestId)
    {
        $contest = Contest::findOrFail($contestId);
        $discussions = ContestDiscussion::where('contest_id', $contestId)
            ->whereNull('parent_id') // Only top-level comments
            ->with('replies', 'user') // Load replies and user info
            ->latest()
            ->get();

        return view('contests.discussions.index', compact('contest', 'discussions'));
    }

    public function store(Request $request, $contestId)
    {
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:contest_discussions,id',
        ]);

        ContestDiscussion::create([
            'contest_id' => $contestId,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Comment posted successfully.');
    }
}
