<?php

namespace App\Http\Controllers;

use App\Repositories\Question\QuestionRepositoryInterface;
use App\Repositories\Tag\TagRepositoryInterface;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $questionRepository;
    protected $tagRepository;

    public function __construct(
        QuestionRepositoryInterface $questionRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->questionRepository = $questionRepository;
        $this->tagRepository = $tagRepository;
    }

    public function list()
    {
        $tags = null;
        $tags = $this->tagRepository->withCount($tags, 'questions');
        $tags = $this->tagRepository->paginate($tags, config('constants.tags_per_page'));

        return view('tag.list', compact(['tags']));
    }

    public function listQuestions(Request $request, $tag)
    {
        $sortedBy = $request->query(config('constants.sorted_by'), config('constants.newest'));

        $tag = $this->tagRepository->find($tag);
        $questions = $this->tagRepository->getQuestions($tag);

        $numberOfQuestions = $this->tagRepository->countQuestionsOfTag($questions);

        $questions = $this->tagRepository->sortQuestionsBy($questions, $sortedBy);
        $questions = $this->tagRepository->paginateRelation($questions, config('constants.questions_per_page'));

        $this->questionRepository->countVotesForPage($questions);

        return view('tag.question', compact(
            'questions',
            'numberOfQuestions',
            'sortedBy',
            'tag',
        ));
    }
}
