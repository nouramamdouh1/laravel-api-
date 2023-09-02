<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class appcode extends Notification
{
    use Queueable;
    private $verifcation_code;

    /**
     * Create a new notification instance.
     */
    public function __construct($verifcation_code)
    {
        $this->verifcation_code=$verifcation_code;
    }

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
        //url
        return (new MailMessage)
                    ->line('Your verification code is:')
                    ->line($this->verification_code)
                    ->action('Verify Account', url('http://127.0.0.1:8000/code/verify'))
                    ->line('Thank you for using our application!');
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



