<?php

namespace Tests\Unit\Models;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Content;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use App\Models\Vote;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    protected Question $question;

    protected function setUp(): void
    {
        parent::setUp();
        $this->question = new Question();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->question);
    }

    public function test_table_name()
    {
        $this->assertEquals('questions', $this->question->getTable());
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'user_id',
            'title',
            'views_number',
            'best_answer',
        ], $this->question->getFillable());
    }

    public function test_answers_relation()
    {
        $this->relation_test_hasMany(
            $this->question->answers(),
            'question_id',
            Answer::class
        );
    }

    public function test_contents_relation()
    {
        $this->relation_test_morphMany(
            $this->question->contents(),
            'contentable_type',
            'contentable_id',
            Content::class
        );
    }

    public function test_comments_relation()
    {
        $this->relation_test_morphMany(
            $this->question->comments(),
            'commentable_type',
            'commentable_id',
            Comment::class
        );
    }

    public function test_votes_relation()
    {
        $this->relation_test_morphMany(
            $this->question->votes(),
            'voteable_type',
            'voteable_id',
            Vote::class
        );
    }

    public function test_user_relation()
    {
        $this->relation_test_belongsTo(
            $this->question->user(),
            'user_id',
            'user',
            User::class
        );
    }

    public function test_tags_relation()
    {
        $this->relation_test_belongsToMany(
            $this->question->tags(),
            'question_id',
            'tag_id',
            'id',
            'tags',
            Tag::class
        );
    }
}
