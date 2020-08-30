<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CommentController;
use App\Http\Requests\CommentRequest;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use App\Repositories\Answer\AnswerRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Question\QuestionRepositoryInterface;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    protected $answerMock;
    protected $commentMock;
    protected $questionMock;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->answerMock = Mockery::mock(AnswerRepositoryInterface::class);
        $this->commentMock = Mockery::mock(CommentRepositoryInterface::class);
        $this->questionMock = Mockery::mock(QuestionRepositoryInterface::class);
        $this->faker = Faker::create();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        unset($this->faker);

        parent::tearDown();
    }

    public function test_store_comment_for_question()
    {
        $data = [
            'question_id' => config('test.testing_question_id'),
            'content' => $this->faker->paragraph(config('test.number_of_comment_paragraphs')),
        ];

        $this->questionMock
            ->shouldReceive('find')
            ->with($data['question_id'])
            ->once()
            ->andReturn(new Question);

        $this->commentMock
            ->shouldReceive('createFromModel')
            ->once()
            ->andReturn(new Comment);

        $request = new CommentRequest($data);
        $comment = new CommentController(
            $this->answerMock,
            $this->commentMock,
            $this->questionMock
        );
        $result = $comment->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertTrue($result->isRedirect());
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertEquals(
            route('questions.show', $request['question_id']),
            $result->headers->get('Location')
        );
    }

    public function test_store_comment_for_answer()
    {
        $data = [
            'question_id' => config('test.testing_question_id'),
            'answer_id' => config('test.testing_answer_id'),
            'content' => $this->faker->paragraph(config('test.number_of_comment_paragraphs')),
        ];

        $this->questionMock
            ->shouldReceive('find')
            ->with($data['question_id'])
            ->once()
            ->andReturn(new Question);

        $this->answerMock
            ->shouldReceive('find')
            ->with($data['question_id'])
            ->once()
            ->andReturn(new Answer);

        $this->commentMock
            ->shouldReceive('createFromModel')
            ->once()
            ->andReturn(new Comment);

        $request = new CommentRequest($data);
        $comment = new CommentController(
            $this->answerMock,
            $this->commentMock,
            $this->questionMock
        );
        $result = $comment->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertTrue($result->isRedirect());
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertEquals(
            route('questions.show', $request['question_id']),
            $result->headers->get('Location')
        );
    }

    public function test_store_comment_for_non_existing_question()
    {
        $data = [
            'question_id' => config('test.testing_question_id'),
            'content' => $this->faker->paragraph(config('test.number_of_comment_paragraphs')),
        ];

        $this->questionMock
            ->shouldReceive('find')
            ->with($data['question_id'])
            ->once()
            ->andThrow(new ModelNotFoundException);

        $request = new CommentRequest($data);
        $comment = new CommentController(
            $this->answerMock,
            $this->commentMock,
            $this->questionMock
        );
        $result = $comment->store($request);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('404', $result->getName());
    }

    public function test_store_comment_for_non_existing_answer()
    {
        $data = [
            'question_id' => config('test.testing_question_id'),
            'answer_id' => config('test.testing_answer_id'),
            'content' => $this->faker->paragraph(config('test.number_of_comment_paragraphs')),
        ];

        $this->questionMock
            ->shouldReceive('find')
            ->with($data['question_id'])
            ->once()
            ->andReturn(new Question);

        $this->answerMock
            ->shouldReceive('find')
            ->with($data['question_id'])
            ->once()
            ->andThrow(new ModelNotFoundException);

        $request = new CommentRequest($data);
        $comment = new CommentController(
            $this->answerMock,
            $this->commentMock,
            $this->questionMock
        );
        $result = $comment->store($request);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('404', $result->getName());
    }

    public function test_update_function()
    {
        $data = [
            'question_id' => config('test.testing_question_id'),
            'content' => $this->faker->paragraph(config('test.number_of_comment_paragraphs')),
        ];

        $this->commentMock
            ->shouldReceive('update')
            ->once()
            ->andReturn(true);

        $request = new CommentRequest($data);
        $comment = new CommentController(
            $this->answerMock,
            $this->commentMock,
            $this->questionMock
        );
        $result = $comment->update($request, new Comment);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertTrue($result->isRedirect());
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertEquals(
            route('questions.show', $request['question_id']),
            $result->headers->get('Location')
        );
    }

    public function test_delete_function()
    {
        $data = [
            'question_id' => config('test.testing_question_id'),
        ];

        $this->commentMock
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $request = new CommentRequest($data);
        $comment = new CommentController(
            $this->answerMock,
            $this->commentMock,
            $this->questionMock
        );
        $result = $comment->destroy($request, new Comment);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertTrue($result->isRedirect());
        $this->assertEquals(302, $result->getStatusCode());
        $this->assertEquals(
            route('questions.show', $request['question_id']),
            $result->headers->get('Location')
        );
    }
}
