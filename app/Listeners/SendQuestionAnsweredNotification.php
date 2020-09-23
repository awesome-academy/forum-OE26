<?php

namespace App\Listeners;

use App\Events\QuestionAnswered;
use App\Notifications\QuestionAnswered as NotificationsQuestionAnswered;
use App\Repositories\Question\QuestionRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendQuestionAnsweredNotification
{
    protected $questionRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Handle the event.
     *
     * @param  QuestionAnswered  $event
     * @return void
     */
    public function handle(QuestionAnswered $event)
    {
        $question = $this->questionRepository->find($event->data['question_id']);
        $user = $this->questionRepository->getUser($question);

        if ($user->id !== $event->data['creation_user_id']) {
            $user->notify(new NotificationsQuestionAnswered($event->data));
        }
    }
}
