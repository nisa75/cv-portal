<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewApplicationReceived extends Notification
{
    use Queueable;

    public function __construct(
        public Application $application
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_application',
            'message' => 'Yeni bir iş başvurusu aldınız.',
            'candidate_name' => $this->application->user->name,
            'job_title' => $this->application->job->title,
        ];
    }
}