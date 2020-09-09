<?php

namespace App\Repositories\Vote;

use Illuminate\Database\Eloquent\Model;

interface VoteRepositoryInterface
{
    public function sumVote(Model $model): int;

    public function getVoteByUserId(Model $model, ?int $userId): ?Model;
}
