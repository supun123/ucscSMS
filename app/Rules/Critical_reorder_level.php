<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Critical_reorder_level implements Rule
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
        $rule = '/^[0-9]{4}$/';
        return preg_match($rule,$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The critical reorder level must be a valid critical reorder level.';
    }
}
