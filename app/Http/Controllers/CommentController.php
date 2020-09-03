<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Repositories\Answer\AnswerRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Question\QuestionRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $answerRepository;
    protected $commentRepository;
    protected $questionRepository;

    public function __construct(
        AnswerRepositoryInterface $answerRepository,
        CommentRepositoryInterface $commentRepository,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->answerRepository = $answerRepository;
        $this->commentRepository = $commentRepository;
        $this->questionRepository = $questionRepository;

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
        try {
            $question = $this->questionRepository->find($request->question_id);

            if (isset($request->answer_id)) {
                $answer = $this->answerRepository->find($request->answer_id);
            }
        } catch (ModelNotFoundException $exception) {
            return view('404');
        }

        $data = [
            'user_id' => Auth::id(),
            'content' => $request->content,
        ];
        $this->commentRepository->createFromModel(isset($answer) ? $answer : $question, $data);

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
        $data = [
            'content' => $request->content,
        ];
        $this->commentRepository->update($comment->id, $data);

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
        $this->commentRepository->delete($comment->id);

        return redirect()->route('questions.show', $request->question_id);
    }
}
