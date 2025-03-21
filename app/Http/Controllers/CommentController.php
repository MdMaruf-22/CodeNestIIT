<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Problem;

class CommentController extends Controller
{
    //
    public function store(Request $request, $problemId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'problem_id' => $problemId,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        return back()->with('success', 'Comment posted successfully!');
    }
}
