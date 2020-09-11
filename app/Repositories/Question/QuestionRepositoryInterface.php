<?php

namespace App\Repositories\Question;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;

interface QuestionRepositoryInterface
{
    public function countVotesForPage(LengthAwarePaginator $page): void;

    public function getTitle(Model $question): string;

    public function getAskedTimestamp(Model $question): array;

    public function getTags(Model $question): Collection;

    public function getUser(Model $question): Model;

    public function getAnswers(Model $question): Collection;

    public function search(string $query): SupportCollection;

    public function addSearchCondition(Builder $query, string $searchString): Builder;
}
