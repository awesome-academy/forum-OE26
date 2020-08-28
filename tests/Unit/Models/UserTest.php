<?php

namespace Tests\Unit\Models;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Role;
use App\Models\User;
use App\Models\Vote;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->user);
    }

    public function test_table_name()
    {
        $this->assertEquals('users', $this->user->getTable());
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'name',
            'email',
            'password',
            'role_id',
            'location',
            'title',
            'description',
        ], $this->user->getFillable());
    }

    public function test_hidden()
    {
        $this->assertEquals([
            'password',
            'remember_token',
        ], $this->user->getHidden());
    }

    public function test_questions_relation()
    {
        $this->relation_test_hasMany(
            $this->user->questions(),
            'user_id',
            Question::class
        );
    }

    public function test_answers_relation()
    {
        $this->relation_test_hasMany(
            $this->user->answers(),
            'user_id',
            Answer::class
        );
    }

    public function test_comments_relation()
    {
        $this->relation_test_hasMany(
            $this->user->comments(),
            'user_id',
            Comment::class
        );
    }

    public function test_votes_relation()
    {
        $this->relation_test_hasMany(
            $this->user->votes(),
            'user_id',
            Vote::class
        );
    }

    public function test_role_relation()
    {
        $this->relation_test_belongsTo(
            $this->user->role(),
            'role_id',
            'role',
            Role::class
        );
    }
}
