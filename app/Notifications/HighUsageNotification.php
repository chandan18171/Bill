<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HighUsageNotification extends Notification
{
    use Queueable;

    protected $property, $type, $msg;

    public function __construct($property, $type, $msg)
    {
        $this->property = $property;
        $this->type = $type;
        $this->msg = $msg;
    }

    public function via($notifiable)
    {
        return ['mail']; // Mail channel
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Alert: High " . ucfirst($this->type) . " Usage")
                    ->greeting("Hello {$notifiable->name},")
                    ->line($this->msg)
                    ->action('View Dashboard', url('/dashboard'))
                    ->line('Consider optimizing your utility usage to avoid high invoices.');
    }
}
