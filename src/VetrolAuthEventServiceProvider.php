<?php

namespace Vetrol\Auth;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Vetrol\Auth\Events\UserEmailAddressAdded;
use Vetrol\Auth\Listeners\SendEmailVerificationNotification;

class VetrolAuthEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        UserEmailAddressAdded::class => [
            SendEmailVerificationNotification::class,
        ],
    ];
}
