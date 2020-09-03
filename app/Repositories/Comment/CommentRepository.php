<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel(): string
    {
        return Comment::class;
    }

    public function createFromModel(Model $model, array $data = []): Model
    {
        if ($model) {
            $relation = $model->comments();
            if ($relation && isset($data['user_id']) && isset($data['content'])) {
                return $relation->create($data);
            }

            return null;
        }

        return null;
    }
}
