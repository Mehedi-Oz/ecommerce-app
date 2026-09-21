<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class BangladeshiPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * Accepts Bangladeshi mobile numbers in local (01XXXXXXXXX) or
     * international (+8801XXXXXXXXX) format.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! preg_match('/^(\+?880|0)1[3-9]\d{8}$/', $value)) {
            $fail(__('The :attribute must be a valid Bangladeshi mobile number.'));
        }
    }
}
