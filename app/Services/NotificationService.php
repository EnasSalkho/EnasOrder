<?php

namespace App\Services;

use Illuminate\Support\Facades\Notification;


class NotificationService
{
    public function send($notifiable, $notification)
    {
        if (method_exists($notification, 'isDisabled') && $notification->isDisabled()) {
            return;
        }

        $notifiable->notify($notification);
    }
    public function sendWithDelay($notifiable, Notification $notification, $delay)
    {
        $notifiable->notify($notification->delay($delay));
    }
}
