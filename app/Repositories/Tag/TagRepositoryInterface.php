<?php

namespace App\Repositories\Tag;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;

interface TagRepositoryInterface
{
    public function getQuestions(Model $tag): Relation;

    public function countQuestionsOfTag(Relation $relation): int;

    public function sortQuestionsBy(Relation $relation, string $order): Relation;

    public function paginateRelation(Relation $relation, int $itemPerPage): LengthAwarePaginator;
}
