<?php

namespace App\Repositories\Role;

use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface
{
    public function findByName(string $name): Model;
}
