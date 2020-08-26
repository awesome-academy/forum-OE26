<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function upVote(Request $request)
    {
        if ($request->type === config('constants.question')) {
            $question = Question::findOrFail($request->id);

            if (Auth::check()) {
                $question->activities_count += config('constants.increasing_activities_count');
                $question->save();

                $voteCollection = $question->votes()
                    ->firstOrNew([
                        'user_id' => Auth::id()
                    ]);

                $voteCollection->vote = $voteCollection->vote !== config('constants.up_vote')
                    ? config('constants.up_vote')
                    : config('constants.no_vote');
                $voteCollection->save();

                $vote = $voteCollection->vote;
            }

            $votes_sum = $question->votes()->sum('vote');
        }

        if ($request->type === config('constants.answer')) {
            $answer = Answer::findOrFail($request->id);
            $question = $answer->question()->first();

            if (Auth::check()) {
                $question->activities_count += config('constants.increasing_activities_count');
                $question->save();

                $voteCollection = $answer->votes()
                    ->firstOrNew([
                        'user_id' => Auth::id()
                    ]);

                $voteCollection->vote = $voteCollection->vote !== config('constants.up_vote')
                    ? config('constants.up_vote')
                    : config('constants.no_vote');
                $voteCollection->save();

                $vote = $voteCollection->vote;
            }

            $votes_sum = $answer->votes()->sum('vote');
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
                $question->activities_count += config('constants.increasing_activities_count');
                $question->save();

                $voteCollection = $question->votes()
                    ->firstOrNew([
                        'user_id' => Auth::id()
                    ]);

                $voteCollection->vote = $voteCollection->vote !== config('constants.down_vote')
                    ? config('constants.down_vote')
                    : config('constants.no_vote');
                $voteCollection->save();

                $vote = $voteCollection->vote;
            }

            $votes_sum = $question->votes()->sum('vote');
        }

        if ($request->type === config('constants.answer')) {
            $answer = Answer::findOrFail($request->id);
            $question = $answer->question()->first();

            if (Auth::check()) {
                $question->activities_count += config('constants.increasing_activities_count');
                $question->save();

                $voteCollection = $answer->votes()
                    ->firstOrNew([
                        'user_id' => Auth::id()
                    ]);

                $voteCollection->vote = $voteCollection->vote !== config('constants.down_vote')
                    ? config('constants.down_vote')
                    : config('constants.no_vote');
                $voteCollection->save();

                $vote = $voteCollection->vote;
            }

            $votes_sum = $answer->votes()->sum('vote');
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
