<?php

namespace App\Http\Controllers;

use App\Repositories\Question\QuestionRepositoryInterface;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function searchQuestion($query)
    {
        return $this->questionRepository->search($query);
    }

    public function searchedQuestions(Request $request)
    {
        $query = $request->query(config('constants.query'));
        $sortedBy = $request->query(config('constants.sorted_by'));

        if (isset($query)) {
            $request->session()
                ->put(config('constants.search_query'), $query);
        } else {
            $query = $request->session()
                ->get(config('constants.search_query'), config('constants.default_search_query'));
        }

        if (isset($sortedBy)) {
            $request->session()
                ->put(config('constants.sorted_by'), $sortedBy);
        } else {
            $sortedBy = $request->session()
                ->get(config('constants.sorted_by'), config('constants.newest'));
        }

        $questions = null;
        $questions = $this->questionRepository->with($questions, 'votes', 'user', 'tags');
        $questions = $this->questionRepository->withCount($questions, 'answers');
        $questions = $this->questionRepository->addSearchCondition($questions, $query);

        $numberOfQuestions = $this->questionRepository->count($questions);

        switch ($sortedBy) {
            case config('constants.active'):
                $questions = $this->questionRepository->orderByDesc($questions, 'activities_count');
                break;
            case config('constants.unanswered'):
                $questions = $this->questionRepository->withCount($questions, 'answers');
                $questions = $this->questionRepository->orderByAsc($questions, 'created_at', 'answers_count');
                break;
            default:
                $questions = $this->questionRepository->orderByDesc($questions, 'created_at');
        }

        $questions = $this->questionRepository->paginate($questions, config('constants.questions_per_page'));
        $this->questionRepository->countVotesForPage($questions);

        return view('search', compact(
            'questions',
            'numberOfQuestions',
            'sortedBy',
            'query'
        ));
    }
}
