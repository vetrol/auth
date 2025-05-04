<?php

use Illuminate\Support\Facades\Route;
use Vetrol\Auth\Http\Controllers\EmailAddressController;

Route::middleware(['web', 'auth'])->prefix('auth/email-addresses')->group(function () {
    Route::get('/', [EmailAddressController::class, 'index']);
    Route::post('/', [EmailAddressController::class, 'store']);
    Route::delete('{emailAddress}', [EmailAddressController::class, 'destroy']);
    Route::post('{emailAddress}/set-primary', [EmailAddressController::class, 'setPrimary']);
    Route::get('verify/{id}/{hash}', [EmailAddressController::class, 'verify'])
        ->name('vetrol-auth.email.verify')
        ->middleware(config('vetrol-auth.verify_route_middleware', ['signed', 'throttle:6,1']));
});
