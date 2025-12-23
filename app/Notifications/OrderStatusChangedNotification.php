<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
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
            ->subject('Order Status Updated')
            ->line('Your order #' . $this->data['order_id'] . ' status has changed.')
            ->line('New status: ' . $this->data['status']);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Order Status Updated',
            'message' => 'Order #' . $this->data['order_id'] . ' status is now ' . $this->data['status']
        ];
    }
}
