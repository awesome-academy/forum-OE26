<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function create(array $data = []): Model;

    public function save(Model $model): bool;

    public function find(int $id): Model;

    public function paginate(
        string $sortedField = 'created_at',
        bool $asc = true,
        int $itemsPerPage
    ): LengthAwarePaginator;

    public function all(): Collection;

    public function update(int $id, array $data = []): bool;

    public function selfUpdate(Model $model, array $data): bool;

    public function delete(int $id): bool;

    public function selfDelete(Model $model): bool;
}
