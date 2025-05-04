<?php

namespace Vetrol\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailAddressStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:'.config('vetrol-auth.user_email_addresses_table'),
        ];
    }
}
