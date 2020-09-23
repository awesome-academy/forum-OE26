<?php

namespace App\Mail;

use App\Repositories\Question\QuestionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminRecurringMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(QuestionRepositoryInterface $questionRepository)
    {
        $questions = $questionRepository->getLastWeekQuestions();
        $questions = $questionRepository->withCount($questions, 'answers', 'comments');
        $questions = $questionRepository->countComments($questions);

        $now = Carbon::now()->format('d-m-Y');

        return $this->markdown('emails.admin', compact('questions', 'now'));
    }
}
