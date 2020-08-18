<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(config('permission.create_comment'))
            ? Response::allow()
            : Response::deny(trans('messages.permission_deny'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        $isOwner = $user->id === $comment->user->id;

        return $isOwner && $user->hasPermission(config('permission.update_comment'))
            ? Response::allow()
            : Response::deny(trans('messages.permission_deny'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        $adminRoleIds = Role::whereIn('name', [
            config('roles.root_admin'),
            config('roles.admin'),
        ])
            ->pluck('id')
            ->toArray();

        $isAdmin = in_array($user->role->id, $adminRoleIds);

        $isOwner = $user->id === $comment->user->id;

        return ($isOwner || $isAdmin) && $user->hasPermission(config('permission.update_comment'))
            ? Response::allow()
            : Response::deny(trans('messages.permission_deny'));
    }
}
