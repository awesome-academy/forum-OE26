<?php

namespace App\Repositories\Answer;

use App\Models\Answer;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class AnswerRepository extends BaseRepository implements AnswerRepositoryInterface
{
    public function getModel(): string
    {
        return Answer::class;
    }

    public function getQuestion(Model $answer): ?Model
    {
        if ($question = $answer->question) {
            return $question;
        }

        return null;
    }
}
