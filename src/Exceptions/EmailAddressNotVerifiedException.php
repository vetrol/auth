<?php

namespace Vetrol\Auth\Exceptions;

/**
 * Class EmailAddressNotVerifiedException
 *
 * This exception is thrown when an email address is not verified.
 */
class EmailAddressNotVerifiedException extends \Exception
{
    /**
     * EmailAddressNotVerifiedException constructor.
     *
     * @param  string  $emailAddress  The email address that is not verified.
     */
    public function __construct(string $emailAddress = '')
    {
        parent::__construct("Email address '{$emailAddress}' is not verified.");
    }
}
