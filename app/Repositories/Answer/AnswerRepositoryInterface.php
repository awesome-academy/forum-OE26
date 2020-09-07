<?php

namespace App\Repositories\Answer;

use Illuminate\Database\Eloquent\Model;

interface AnswerRepositoryInterface
{
    public function getQuestion(Model $answer): Model;
}
