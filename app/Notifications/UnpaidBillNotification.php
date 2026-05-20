<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnpaidBillNotification extends Notification
{
    use Queueable;

    protected $bill;

    public function __construct($bill)
    {
        $this->bill = $bill;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Reminder: Unpaid {$this->bill->type} Bill")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("This is a reminder that you have an unpaid {$this->bill->type} bill for \${$this->bill->amount}.")
                    ->line("Please make the payment before {$this->bill->due_date}.")
                    ->action('View Invoice', url("/bills/{$this->bill->id}"))
                    ->error();
    }
}
