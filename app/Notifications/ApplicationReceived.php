<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationReceived extends Notification
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
            'type' => 'application_received',
            'message' => 'Başvurunuz başarıyla gönderildi.',
            'job_title' => $this->application->job->title,
            'company_name' => $this->application->job->company->name,
        ];
    }
}