<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
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
        return $user->hasPermission(config('permission.create_answer'))
            ? Response::allow()
            : Response::deny(trans('messages.permission_deny'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return mixed
     */
    public function update(User $user, Answer $answer)
    {
        $isOwner = $user->id === $answer->user->id;

        return $isOwner && $user->hasPermission(config('permission.update_answer'))
            ? Response::allow()
            : Response::deny(trans('messages.permission_deny'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return mixed
     */
    public function delete(User $user, Answer $answer)
    {
        //
    }
}
