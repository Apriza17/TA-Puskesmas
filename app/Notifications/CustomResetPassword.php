<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    public function __construct(public string $token) {}

    public function via($notifiable) { return ['mail']; }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Memperbarui Password | SIM-POSDA')
            ->view('emails.reset-password', ['url' => $url, 'user' => $notifiable]);
    }
}

