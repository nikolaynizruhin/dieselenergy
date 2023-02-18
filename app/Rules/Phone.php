<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    /**
     * Phone number regex pattern.
     *
     * @var string
     */
    const REGEX = '/^\+380[0-9]{9}$/';

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        return preg_match(self::REGEX, $value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return trans('validation.phone');
    }
}
