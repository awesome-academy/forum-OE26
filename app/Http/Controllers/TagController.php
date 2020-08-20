<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function list()
    {
        $tags = Tag::withCount('questions')
            ->paginate(config('constants.tags_per_page'));

        return view('tag.list', compact(['tags']));
    }

    public function listQuestions(Request $request, $tag)
    {
        $sortedBy = $request->query(config('constants.sorted_by'), config('constants.newest'));

        $questions = Tag::findOrFail($tag)
            ->questions()
            ->with('votes', 'user')
            ->withCount('answers');
        $numberOfQuestions = $questions->count();

        switch ($sortedBy) {
            case config('constants.active'):
                $questions = $questions->orderByDesc('activities_count');
                break;
            case config('constants.unanswered'):
                $questions = $questions->withCount('answers')
                    ->orderBy('created_at')
                    ->orderBy('answers_count');
                break;
            default:
                $questions = $questions->orderByDesc('created_at');
        }

        $questions = $questions->paginate(config('constants.questions_per_page'));
        $questions->map(function ($answer) {
            $answer->sum_votes = $answer->votes->sum('vote');
        });

        return view('tag.question', compact(
            'questions',
            'numberOfQuestions',
            'sortedBy',
            'tag',
        ));
    }
}
