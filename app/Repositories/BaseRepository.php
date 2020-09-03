<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel(): string;

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function create(array $data = []): Model
    {
        return $this->model->create($data);
    }

    public function save(Model $model): bool
    {
        return $model->save();
    }

    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function paginate(
        string $sortedField = 'created_at',
        bool $asc = true,
        int $itemsPerPage
    ): LengthAwarePaginator {
        if ($asc) {
            $ordered = $this->model->orderBy($sortedField, 'asc');
        } else {
            $ordered = $this->model->orderBy($sortedField, 'desc');
        }

        return $ordered->paginate($itemsPerPage);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function update(int $id, array $data = []): bool
    {
        $result = $this->find($id);

        if ($result) {
            $updated = $result->update($data);

            return $updated;
        }

        return false;
    }

    public function selfUpdate(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    public function delete(int $id): bool
    {
        $result = $this->find($id);

        if ($result) {
            $deleted = $result->delete();

            return $deleted;
        }

        return false;
    }

    public function selfDelete(Model $model): bool
    {
        return $model->delete();
    }
}
