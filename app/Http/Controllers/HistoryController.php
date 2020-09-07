<?php

namespace App\Http\Controllers;

use App\Repositories\Answer\AnswerRepositoryInterface;
use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\Question\QuestionRepositoryInterface;

class HistoryController extends Controller
{
    protected $answerRepository;
    protected $contentRepository;
    protected $questionRepository;

    public function __construct(
        AnswerRepositoryInterface $answerRepository,
        ContentRepositoryInterface $contentRepository,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->answerRepository = $answerRepository;
        $this->contentRepository = $contentRepository;
        $this->questionRepository = $questionRepository;
    }

    public function getHistory($type, $id)
    {
        $contents = [];
        if ((int)$type === config('constants.question')) {
            $question = $this->questionRepository->find($id);
            $contents = $this->contentRepository->getHistory($question);
        }

        if ((int)$type === config('constants.answer')) {
            $answer = $this->answerRepository->find($id);
            $contents = $this->contentRepository->getHistory($answer);
        }

        return view('history', compact([
            'contents',
        ]));
    }
}
