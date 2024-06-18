<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class MunicipalOwnership implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = Auth::user(); 
        
        if (empty($value)) $fail("no municipal provided");
        if ($user->hasAnyRole(['regional','national'])) return;
        if ($value != $user->municipal_id) abort(403,"You don't have access to municipal");
    }
}
