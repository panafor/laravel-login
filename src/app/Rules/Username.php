<?php

namespace Usermp\LaravelLogin\app\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Username implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidEmail($value) && !$this->isValidPersianPhoneNumber($value)) {
            $fail('The :attribute must be a valid email or Persian phone number.');
        }
    }

    /**
     * Check if the value is a valid email.
     *
     * @param  string  $value
     * @return bool
     */
    protected function isValidEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Check if the value is a valid Persian phone number.
     *
     * @param  string  $value
     * @return bool
     */
    protected function isValidPersianPhoneNumber(string $value): bool
    {
        return preg_match('/^09[0-9]{9}$/', $value);
    }
}
