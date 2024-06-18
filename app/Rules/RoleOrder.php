<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RoleOrder implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::find($value);
        if (empty($user)) {
            $fail("User does not exist.");
        }
        if (Auth::user()->role != 'national' && Auth::id() != $user['id'] && array_search(Auth::user()->role, config('constants.roles')) <= array_search($user->role, config('constants.roles'))) {
            $fail("Your Role is too low to modify their personal details.");
        }
    }
}
