<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function create(array $data = []): Model;

    public function save(Model $model): bool;

    public function find(int $id): Model;

    public function show(
        string $sortedField = 'created_at',
        bool $asc = true,
        int $itemsPerPage
    ): LengthAwarePaginator;

    public function all(): Collection;

    public function update(int $id, array $data = []): bool;

    public function selfUpdate(Model $model, array $data): bool;

    public function delete(int $id): bool;

    public function selfDelete(Model $model): bool;

    public function with(?Builder $query, string ...$relationships): Builder;

    public function withCount(?Builder $query, string ...$relationships): Builder;

    public function orderByAsc(Builder $query, string ...$fields): Builder;

    public function orderByDesc(Builder $query, string ...$fields): Builder;

    public function paginate(Builder $query, int $itemsPerPage): LengthAwarePaginator;

    public function count(?Builder $query): int;

    public function sync(Model $model, string $relatedRelationName, ?array $data): void;

    public function get(Builder $query): Collection;
}
