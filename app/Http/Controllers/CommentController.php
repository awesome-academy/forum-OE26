<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $comment = Question::findOrFail($request->question_id)->comments();

        if (isset($request->answer_id)) {
            $comment = Answer::findOrFail($request->answer_id)->comments();
        }

        $comment->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('questions.show', $request->question_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('questions.show', $request->question_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        $comment->delete();

        return redirect()->route('questions.show', $request->question_id);
    }
}
