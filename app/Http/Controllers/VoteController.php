<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Repositories\Answer\AnswerRepositoryInterface;
use App\Repositories\Question\QuestionRepositoryInterface;
use App\Repositories\Vote\VoteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    protected $answerRepository;
    protected $questionRepository;
    protected $voteRepository;

    public function __construct(
        AnswerRepositoryInterface $answerRepository,
        QuestionRepositoryInterface $questionRepository,
        VoteRepositoryInterface $voteRepository
    ) {
        $this->answerRepository = $answerRepository;
        $this->questionRepository = $questionRepository;
        $this->voteRepository = $voteRepository;
    }

    public function upVote(Request $request)
    {
        if ($request->type === config('constants.question')) {
            $question = $this->questionRepository->find($request->id);

            if (Auth::check()) {
                $vote = $this->voteRepository->upVoteForQuestion($question);
            }

            $votes_sum = $this->voteRepository->sumVote($question);
        }

        if ($request->type === config('constants.answer')) {
            $answer = Answer::findOrFail($request->id);
            $question = $answer->question()->first();

            if (Auth::check()) {
                $vote = $this->voteRepository->upVoteForAnswer($question, $answer);
            }

            $votes_sum = $this->voteRepository->sumVote($answer);
        }

        if (!isset($vote)) {
            return response()->json([
                'votes_sum' => $votes_sum ?? config('constants.no_vote'),
            ]);
        }

        return response()->json([
            'vote' => $vote,
            'votes_sum' => $votes_sum ?? config('constants.no_vote'),
        ]);
    }

    public function downVote(Request $request)
    {
        if ($request->type === config('constants.question')) {
            $question = Question::findOrFail($request->id);

            if (Auth::check()) {
                $vote = $this->voteRepository->downVoteForQuestion($question);
            }

            $votes_sum = $this->voteRepository->sumVote($question);
        }

        if ($request->type === config('constants.answer')) {
            $answer = Answer::findOrFail($request->id);
            $question = $answer->question()->first();

            if (Auth::check()) {
                $vote = $this->voteRepository->downVoteForAnswer($question, $answer);
            }

            $votes_sum = $this->voteRepository->sumVote($answer);
        }

        if (!isset($vote)) {
            return response()->json([
                'votes_sum' => $votes_sum,
            ]);
        }

        return response()->json([
            'vote' => $vote,
            'votes_sum' => $votes_sum,
        ]);
    }
}
