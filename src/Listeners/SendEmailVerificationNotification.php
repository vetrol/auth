<?php

namespace Vetrol\Auth\Listeners;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Vetrol\Auth\Events\UserEmailAddressAdded;

class SendEmailVerificationNotification
{
    public function handle(UserEmailAddressAdded $event)
    {
        if ($event->userEmailAddress instanceof MustVerifyEmail && ! $event->userEmailAddress->hasVerifiedEmail()) {
            VerifyEmail::createUrlUsing(function ($notifiable) {
                return URL::temporarySignedRoute('verification.verify-user-email',
                    Carbon::now()->addMinutes(Config::get('vetrol-auth.email_verification_link_expiry', 60)),
                    [
                        'id' => $notifiable->getKey(),
                        'hash' => sha1($notifiable->getEmailForVerification()),
                    ]
                );
            });

            $event->userEmailAddress->sendEmailVerificationNotification();
        }
    }
}
