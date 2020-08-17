<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchQuestion($query)
    {
        return Question::where('title', 'LIKE', '%' . $query . '%')
            ->limit(config('constants.search_result_limit'))
            ->pluck('title');
    }

    public function searchedQuestions(Request $request)
    {
        $query = $request->query(config('constants.query'));
        $sortedBy = $request->query(config('constants.sorted_by'), config('constants.newest'));

        $questions = Question::with('votes', 'user')
            ->withCount('answers')
            ->where('title', 'LIKE', '%' . $query . '%');
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

        return view('search', compact(
            'questions',
            'numberOfQuestions',
            'sortedBy',
            'query'
        ));
    }
}
