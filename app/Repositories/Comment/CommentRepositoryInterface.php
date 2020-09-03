<?php

namespace App\Repositories\Comment;

use Illuminate\Database\Eloquent\Model;

interface CommentRepositoryInterface
{
    public function createFromModel(Model $model, array $data = []): Model;
}
