<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use App\Policies\AnswerPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\CommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('dashboard', function ($user) {
            $rootId = Role::where('name', 'LIKE', config('roles.root_admin'))
                ->first()
                ->id;

            return $user->role_id === $rootId;
        });

        Gate::define('change_role', function ($user, User $model) {
            $adminRoleId = Role::where('name', 'LIKE', config('roles.root_admin'))
                ->first()
                ->id;

            return $user->role->id === $adminRoleId
                && $model->role->id !== $adminRoleId;
        });
    }
}
