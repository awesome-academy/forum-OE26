<?php

namespace App\Repositories\Vote;

use App\Models\Vote;
use App\Repositories\BaseRepository;
use App\Repositories\PolymorphicRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class VoteRepository extends BaseRepository implements VoteRepositoryInterface, PolymorphicRepositoryInterface
{
    public function getModel(): string
    {
        return Vote::class;
    }

    public function sumVote(Model $model): int
    {
        if ($votes = $model->votes) {
            return $votes->sum('vote');
        }

        return 0;
    }

    public function getVoteByUserId(Model $model, ?int $userId): ?Model
    {
        if ($relation = $model->votes()) {
            return $relation
                ->where('user_id', $userId)
                ->first();
        }

        return null;
    }

    public function createFromModel(Model $model, array $data = []): ?Model
    {
        return null;
    }
}
