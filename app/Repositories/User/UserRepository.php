<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel(): string
    {
        return User::class;
    }

    public function getUserDashboard(int $itemPerPage): LengthAwarePaginator
    {
        return User::withCount('questions')
            ->withCount('answers')
            ->withCount('comments')
            ->withCount('votes')
            ->paginate($itemPerPage);
    }
}
