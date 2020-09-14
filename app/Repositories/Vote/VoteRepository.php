<?php

namespace App\Repositories\Vote;

use App\Models\Vote;
use App\Repositories\BaseRepository;
use App\Repositories\PolymorphicRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function upVoteForQuestion(Model $question): int
    {
        $question->activities_count += config('constants.increasing_activities_count');
        $question->save();

        $voteCollection = $question->votes()
            ->firstOrNew([
                'user_id' => Auth::id()
            ]);

        $voteCollection->vote = $voteCollection->vote !== config('constants.up_vote')
            ? config('constants.up_vote')
            : config('constants.no_vote');
        $voteCollection->save();

        return $voteCollection->vote;
    }

    public function downVoteForQuestion(Model $question): int
    {
        $question->activities_count += config('constants.increasing_activities_count');
        $question->save();

        $voteCollection = $question->votes()
            ->firstOrNew([
                'user_id' => Auth::id()
            ]);

        $voteCollection->vote = $voteCollection->vote !== config('constants.down_vote')
            ? config('constants.down_vote')
            : config('constants.no_vote');
        $voteCollection->save();

        return $voteCollection->vote;
    }

    public function upVoteForAnswer(Model $question, Model $answer): int
    {
        $question->activities_count += config('constants.increasing_activities_count');
        $question->save();

        $voteCollection = $answer->votes()
            ->firstOrNew([
                'user_id' => Auth::id()
            ]);

        $voteCollection->vote = $voteCollection->vote !== config('constants.up_vote')
            ? config('constants.up_vote')
            : config('constants.no_vote');
        $voteCollection->save();

        return $voteCollection->vote;
    }

    public function downVoteForAnswer(Model $question, Model $answer): int
    {
        $question->activities_count += config('constants.increasing_activities_count');
        $question->save();

        $voteCollection = $answer->votes()
            ->firstOrNew([
                'user_id' => Auth::id()
            ]);

        $voteCollection->vote = $voteCollection->vote !== config('constants.down_vote')
            ? config('constants.down_vote')
            : config('constants.no_vote');
        $voteCollection->save();

        return $voteCollection->vote;
    }
}
