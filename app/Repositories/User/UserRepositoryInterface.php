<?php

namespace App\Repositories\User;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getUserDashboard(int $itemPerPage): LengthAwarePaginator;
}
