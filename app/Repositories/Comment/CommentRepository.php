<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use App\Repositories\PolymorphicRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface, PolymorphicRepositoryInterface
{
    public function getModel(): string
    {
        return Comment::class;
    }

    public function getCommentsWithUser(Model $model): ?Collection
    {
        if ($relation = $model->comments()) {
            return $relation
                ->with('user')
                ->get();
        }

        return null;
    }

    public function createFromModel(Model $model, array $data = []): ?Model
    {
        if (
            isset($data['user_id'])
            && isset($data['content'])
            && $relation = $model->comments()
        ) {
            return $relation->create($data);
        }

        return null;
    }
}
