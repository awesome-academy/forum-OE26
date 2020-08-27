<?php

namespace Tests\Unit\Models;

use App\Models\Answer;
use App\Models\Content;
use App\Models\Question;
use Tests\TestCase;

class ContentTest extends TestCase
{
    protected Content $content;

    protected function setUp(): void
    {
        parent::setUp();
        $this->content = new Content();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->content);
    }

    public function test_table_name()
    {
        $this->assertEquals('contents', $this->content->getTable());
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'content',
            'version',
        ], $this->content->getFillable());
    }

    public function test_hidden()
    {
        $this->assertEquals([
            'created_at',
            'updated_at',
            'contentable_id',
            'contentable_type',
        ], $this->content->getHidden());
    }

    public function test_contentable_relation()
    {
        $this->content->contentable_type = Question::class;
        $this->relation_test_morphTo($this->content->contentable(), Question::class);

        $this->content->contentable_type = Answer::class;
        $this->relation_test_morphTo($this->content->contentable(), Answer::class);
    }
}
