<?php

namespace App\Http\Middleware;

use App\Events\QuestionAnswered;
use Closure;
use Illuminate\Support\Facades\Auth;

class DispatchQuestionAnsweredEvent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if ($response->isOk() || $response->isRedirection()) {
            switch ($request->url()) {
                case route('answers.store'):
                    event(new QuestionAnswered([
                        'question_id' => (int)$request->question_id,
                        'creation_user_id' => Auth::id(),
                        'type' => config('constants.create_answer'),
                        'message_en' => Auth::user()->name . trans('messages.answer_created_en'),
                        'message_vi' => Auth::user()->name . trans('messages.answer_created_vi'),
                    ]));
                    break;
                case route('comments.store'):
                    event(new QuestionAnswered([
                        'question_id' => (int)$request->question_id,
                        'creation_user_id' => Auth::id(),
                        'type' => config('constants.create_comment'),
                        'message_en' => Auth::user()->name . trans('messages.comment_created_en'),
                        'message_vi' => Auth::user()->name . trans('messages.comment_created_vi'),
                    ]));
                    break;
            }
        }
    }
}
