<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Asset_code implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $rule = '/^[ASS]{3}[\/][1,2][0-9]{3}[\-][0-9]{2}[\/][0-9]{3}$/';
        return preg_match($rule,$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid Assets code.';
    }
}
