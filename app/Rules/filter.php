<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class filter implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // if (strtolower($value) == 'laravel') {
        //     $fail('This Name is allowed!');
        // }

        //عند استدعاء الكلاس 
        //new filter();
    }
}
