<?php

namespace Vetrol\Auth\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Vetrol\Auth\Models\UserEmailAddress;

trait HasEmailAddresses
{
    public function emailAddresses(): MorphMany
    {
        return $this->morphMany(UserEmailAddress::class, 'emailable');
    }

    public function primaryEmailAddress()
    {
        return $this->emailAddresses()->where('is_primary', true)->first();
    }

    public function addEmailAddress($email, $isPrimary = false)
    {
        return $this->emailAddresses()->create([
            'email' => $email,
            'is_primary' => $isPrimary,
        ]);
    }

    public function removeEmailAddress($email)
    {
        return $this->emailAddresses()->where('email', $email)->delete();
    }

    public function verifyEmailAddress($email)
    {
        return $this->emailAddresses()
            ->where('email', $email)
            ->update(['email_verified_at' => now()]);
    }

    public function unverifyEmailAddress($email)
    {
        return $this->emailAddresses()
            ->where('email', $email)
            ->update(['email_verified_at' => null]);
    }

    public function hasVerifiedEmailAddress($email)
    {
        return $this->emailAddresses()
            ->where('email', $email)
            ->whereNotNull('email_verified_at')
            ->exists();
    }
}
