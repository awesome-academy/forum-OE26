<?php

namespace Tests\Unit\Models;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use App\Models\User;
use Tests\TestCase;

class CommentTest extends TestCase
{
    protected Comment $comment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->comment = new Comment();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->comment);
    }

    public function test_table_name()
    {
        $this->assertEquals('comments', $this->comment->getTable());
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'user_id',
            'content',
        ], $this->comment->getFillable());
    }

    public function test_commentable_relation()
    {
        $this->comment->commentable_type = Question::class;
        $this->relation_test_morphTo($this->comment->commentable(), Question::class);

        $this->comment->commentable_type = Answer::class;
        $this->relation_test_morphTo($this->comment->commentable(), Answer::class);
    }

    public function test_user_relation()
    {
        $this->relation_test_belongsTo(
            $this->comment->user(),
            'user_id',
            'user',
            User::class
        );
    }
}
