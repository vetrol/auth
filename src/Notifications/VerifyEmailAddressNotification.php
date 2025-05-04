<?php

namespace Vetrol\Auth\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailAddressNotification extends Notification
{
    public $verificationUrl;

    public function __construct($verificationUrl)
    {
        $this->verificationUrl = $verificationUrl;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('Verify Your Email Address'))
            ->line(__('Click the button below to verify your email address.'))
            ->action(__('Verify Email Address'), $this->verificationUrl)
            ->line(__('If you did not request this, you can ignore this email.'));
    }
}
