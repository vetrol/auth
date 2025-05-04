<?php

namespace Vetrol\Auth\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Vetrol\Auth\Models\UserEmailAddress;

class UserEmailAddressAdded
{
    use Dispatchable, SerializesModels;

    public function __construct(public UserEmailAddress $userEmailAddress) {}
}
