<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function getModel(): string
    {
        return Role::class;
    }

    public function findByName(string $name): Model
    {
        return Role::where('name', $name)->firstOrFail();
    }
}
