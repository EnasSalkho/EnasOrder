<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OperationFailedNotification extends Notification
{
    use Queueable;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Operation Failed')
            ->line('An operation has failed.')
            ->line('Reason: ' . $this->data['reason']);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Operation Failed',
            'message' => $this->data['reason']
        ];
    }
    public function isDisabled(): bool
    {
        return false;
    }

}
