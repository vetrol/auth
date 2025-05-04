<?php

namespace Vetrol\Auth\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Vetrol\Auth\Models\UserEmailAddress;

class UserEmailAddressAdded
{
    use Dispatchable, SerializesModels;

    public function __construct(public UserEmailAddress $userEmailAddress)
    {
    }
}
