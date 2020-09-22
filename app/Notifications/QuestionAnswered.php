<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionAnswered extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'broadcast',
            'database',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'question_id' => $this->data['question_id'],
            'message_en' => $this->data['message_en'],
            'message_vi' => $this->data['message_vi'],
        ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'question_id' => $this->data['question_id'],
            'creation_user_id' => $this->data['creation_user_id'],
            'type' => $this->data['type'],
        ];
    }
}
