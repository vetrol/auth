<?php

namespace Vetrol\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Vetrol\Auth\Exceptions\EmailAddressNotVerifiedException;

class UserEmailAddress extends Model implements MustVerifyEmailContract
{
    use MustVerifyEmail, Notifiable;

    protected $guarded = [];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_primary' => 'boolean',
    ];

    public function emailable()
    {
        return $this->morphTo();
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * @throws EmailAddressNotVerifiedException
     */
    public function setAsPrimary(): void
    {
        $allowUnverified = config('vetrol-auth.allow_unverified_emails_as_primary', false);

        if (!$allowUnverified && !$this->hasVerifiedEmail()) {
            throw new EmailAddressNotVerifiedException($this->email);
        }

        $this->emailable->update([
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
        ]);

        $this->update([
            'email' => $this->emailable->getOriginal('email'),
            'email_verified_at' => $this->emailable->getOriginal('email_verified_at'),
        ]);
    }
}
