<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Repositories\Answer\AnswerRepositoryInterface;
use App\Repositories\Content\ContentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    protected $answerRepository;
    protected $contentRepository;

    public function __construct(
        AnswerRepositoryInterface $answerRepository,
        ContentRepositoryInterface $contentRepository
    ) {
        $this->answerRepository = $answerRepository;
        $this->contentRepository = $contentRepository;

        $this->middleware('auth');
        $this->authorizeResource(Answer::class, 'answer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerRequest $request)
    {
        $answer = $this->answerRepository->create([
            'user_id' => Auth::id(),
            'question_id' => $request->question_id,
        ]);

        $this->contentRepository->createFromModel($answer, [
            'content' => $request->content,
            'version' => config('constants.initial_version'),
        ]);

        return redirect()->route('questions.show', $request->question_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        $maxContentVersion = $this->contentRepository->maxVersion($answer);
        $content = $this->contentRepository->findByVersion($maxContentVersion, $answer);

        $answerId = $answer->id;
        $questionId = $answer->question->id;

        return view('answer.edit', compact(
            'answerId',
            'questionId',
            'content',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerRequest $request, Answer $answer)
    {
        $maxContentVersion = $this->contentRepository->maxVersion($answer);
        $this->contentRepository->createFromModel($answer, [
            'content' => $request->content,
            'version' => $maxContentVersion + 1,
        ]);

        return redirect()->route('questions.show', $answer->question->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
