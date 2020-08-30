<?php

namespace App\Repositories\Answer;

use App\Models\Answer;
use App\Repositories\BaseRepository;

class AnswerRepository extends BaseRepository implements AnswerRepositoryInterface
{
    public function getModel(): string
    {
        return Answer::class;
    }
}
