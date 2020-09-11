<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    public function getModel(): string
    {
        return Tag::class;
    }

    public function getQuestions(Model $tag): Relation
    {
        return $tag->questions()
            ->with('votes', 'user')
            ->withCount('answers');
    }

    public function countQuestionsOfTag(Relation $relation): int
    {
        return $relation->count();
    }

    public function sortQuestionsBy(Relation $relation, string $order): Relation
    {
        switch ($order) {
            case config('constants.active'):
                return $relation->orderByDesc('activities_count');
            case config('constants.unanswered'):
                return $relation->withCount('answers')
                    ->orderBy('created_at')
                    ->orderBy('answers_count');
            default:
                return $relation->orderByDesc('created_at');
        }
    }

    public function paginateRelation(Relation $relation, int $itemPerPage): LengthAwarePaginator
    {
        return $relation->paginate($itemPerPage);
    }
}
