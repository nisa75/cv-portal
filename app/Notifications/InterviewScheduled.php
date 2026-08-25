<?php

namespace App\Notifications;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InterviewScheduled extends Notification
{
    use Queueable;

    public function __construct(
        public Interview $interview
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Yeni bir mülakat planlandı.',
            'job_title' => $this->interview->application->job->title,
            'scheduled_at' => $this->interview->scheduled_at->format('d.m.Y H:i'),
        ];
    }
}