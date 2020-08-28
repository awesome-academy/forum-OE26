<?php

namespace Tests\Unit\Models;

use App\Models\Question;
use App\Models\Tag;
use Tests\TestCase;

class TagTest extends TestCase
{
    protected Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tag = new Tag();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->tag);
    }

    public function test_table_name()
    {
        $this->assertEquals('tags', $this->tag->getTable());
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'name',
            'description',
        ], $this->tag->getFillable());
    }

    public function test_questions_relation()
    {
        $this->relation_test_belongsToMany(
            $this->tag->questions(),
            'tag_id',
            'question_id',
            'id',
            'questions',
            Question::class
        );
    }
}
