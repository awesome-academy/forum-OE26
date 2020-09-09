<?php

namespace App\Repositories\Comment;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CommentRepositoryInterface
{
    public function getCommentsWithUser(Model $model): ?Collection;
}
