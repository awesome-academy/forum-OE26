<?php

namespace App\Repositories\Content;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ContentRepositoryInterface
{
    public function maxVersion(Model $model): int;

    public function findByVersion(int $version, Model $model): Model;

    public function getHistory(Model $model): Collection;
}
