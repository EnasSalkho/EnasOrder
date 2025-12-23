<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreatedNotification extends Notification
{
    use Queueable;

    private array $data;
    private bool $disabled = false;

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
            ->subject('New User Created')
            ->line('A new user has been created.')
            ->line('Name: ' . $this->data['name']);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New User',
            'message' => 'User ' . $this->data['name'] . ' created successfully'
        ];
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
