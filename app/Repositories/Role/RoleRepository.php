<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
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

    public function getUserEmails(array $roleNames): Collection
    {
        return Role::join('users', 'roles.id', '=', 'users.role_id')
            ->whereIn('roles.name', $roleNames)
            ->select('users.email')
            ->get();
    }
}
