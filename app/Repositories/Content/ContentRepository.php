<?php

namespace App\Repositories\Content;

use App\Models\Content;
use App\Repositories\BaseRepository;
use App\Repositories\PolymorphicRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ContentRepository extends BaseRepository implements ContentRepositoryInterface, PolymorphicRepositoryInterface
{
    public function getModel(): string
    {
        return Content::class;
    }

    public function createFromModel(Model $model, array $data = []): ?Model
    {
        if (
            isset($data['content'])
            && isset($data['version'])
            && $relation = $model->contents()
        ) {
            return $relation->create($data);
        }

        return null;
    }

    public function maxVersion(Model $model): int
    {
        if ($relation = $model->contents()) {
            return $relation->max('version');
        }

        return 0;
    }

    public function findByVersion(int $version, Model $model): ?Model
    {
        if ($relation = $model->contents()) {
            return $relation
                ->where('version', $version)
                ->first();;
        }

        return null;
    }

    public function getHistory(Model $model): ?Collection
    {
        if ($relation = $model->contents()) {
            return $relation
                ->orderByDesc('version')
                ->get();
        }

        return null;
    }
}
