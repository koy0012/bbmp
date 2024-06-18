<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;


class RateHelper
{ 
    public static function AccountLimit($key, $maxAttempts = 1, $days = 30)
    {

        /** @var User $user */
        $user = Auth::user();
    
        if($user->hasAnyRole(['municipal','national'])){
            return;
        }

        $executed = RateLimiter::attempt(
            key: $key,
            maxAttempts: $maxAttempts,
            callback: function () {
            },
            decaySeconds: $days * 60 * 24 * 60,
        );

        $r = RateLimiter::availableIn($key) + time();
        $time = date("Y-m-d h:i:s a", $r);

        if (!$executed) {
            throw ValidationException::withMessages(["You may update your account again on {$time}"]);
        }
    }
}
