<?php

namespace App\Repositories\Role;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface
{
    public function findByName(string $name): Model;

    public function getUserEmails(array $roleNames): Collection;
}
