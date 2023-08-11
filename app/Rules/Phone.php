<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Phone implements ValidationRule
{
    /**
     * Phone number regex pattern.
     *
     * @var string
     */
    const REGEX = '/^\+380[0-9]{9}$/';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match(self::REGEX, $value)) {
            $fail('validation.phone')->translate();
        }
    }
}
