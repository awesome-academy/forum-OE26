<?php

namespace App\Repositories\Vote;

use Illuminate\Database\Eloquent\Model;

interface VoteRepositoryInterface
{
    public function sumVote(Model $model): int;

    public function getVoteByUserId(Model $model, ?int $userId): ?Model;

    public function upVoteForQuestion(Model $question): int;

    public function downVoteForQuestion(Model $question): int;

    public function upVoteForAnswer(Model $question, Model $answer): int;

    public function downVoteForAnswer(Model $question, Model $answer): int;
}
