<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use App\Repositories\PolymorphicRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface, PolymorphicRepositoryInterface
{
    public function getModel(): string
    {
        return Comment::class;
    }

    public function createFromModel(Model $model, array $data = []): Model
    {
        if (
            $model
            && isset($data['user_id'])
            && isset($data['content'])
            && $relation = $model->comments()
        ) {
            return $relation->create($data);
        }

        return null;
    }
}
