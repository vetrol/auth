<?php

namespace Vetrol\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Vetrol\Auth\Http\Requests\EmailAddressStoreRequest;
use Vetrol\Auth\Models\UserEmailAddress;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

class EmailAddressController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->emailAddresses);
    }

    public function store(EmailAddressStoreRequest $request)
    {
        $emailAddress = Auth::user()->emailAddresses()->create(['email' => $request->email]);

        $verificationUrl = URL::temporarySignedRoute(
            'vetrol-auth.email.verify',
            now()->addMinutes(config('vetrol-auth.email_verification_link_expiry', 60)),
            ['id' => $emailAddress->id, 'hash' => sha1($emailAddress->email)]
        );

        $emailAddress->notify(new \Vetrol\Auth\Notifications\VerifyEmailAddressNotification($verificationUrl));

        return response()->json(['message' => 'Email added. Verification sent.']);
    }

    public function destroy(UserEmailAddress $emailAddress)
    {
        $this->authorize('delete', $emailAddress);
        $emailAddress->delete();

        return response()->json(['message' => 'Email deleted.']);
    }

    public function setPrimary(UserEmailAddress $emailAddress)
    {
        $this->authorize('update', $emailAddress);
        $emailAddress->setAsPrimary();

        return response()->json(['message' => 'Primary email updated.']);
    }

    public function verify(Request $request, $id, $hash)
    {
        $emailAddress = UserEmailAddress::findOrFail($id);

        if (!hash_equals((string)$hash, sha1($emailAddress->email))) {
            abort(403, 'Invalid verification link.');
        }

        if ($emailAddress->hasVerifiedEmail()) {
            return redirect(config('vetrol-auth.magic_link_redirect_to', '/'));
        }

        $emailAddress->markEmailAsVerified();
        event(new Verified($emailAddress));

        return redirect(config('vetrol-auth.magic_link_redirect_to', '/'));
    }
}
