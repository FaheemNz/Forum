<?php

namespace App\Rules;

use App\Exceptions\SpamException;
use App\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;

class SpamRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            (new Spam)->detect($value);
            return true;
        } catch (SpamException $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your post contains spam';
    }
}
