<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function __construct()
    {
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
        $questionId = $request->question_id;
        $answer = Answer::create([
            'user_id' => Auth::id(),
            'question_id' => $questionId,
        ]);

        $answer->contents()
            ->create([
                'content' => $request->content,
                'version' => config('constants.initial_version'),
            ]);

        return redirect()->route('questions.show', $questionId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        $answerId = $answer->id;

        $maxContentVersion = $answer->contents()->max('version');
        $content = $answer->contents()
            ->where('version', $maxContentVersion)
            ->first();

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
        $maxContentVersion = $answer->contents()->max('version');
        $answer->contents()
            ->create([
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
