<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface PolymorphicRepositoryInterface
{
    public function createFromModel(Model $model, array $data = []): ?Model;
}
