<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IntegrationFailed extends Notification
{
    use Queueable;

    public function __construct(
        public string $integrationName,
        public string $errorMessage
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->error()
                    ->subject("Integration Failed: {$this->integrationName}")
                    ->line("The integration '{$this->integrationName}' has failed after multiple retries.")
                    ->line("Error Message: {$this->errorMessage}")
                    ->action('View Logs', url('/integrations'))
                    ->line('Please investigate immediately.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
