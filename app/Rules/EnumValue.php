<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class EnumValue implements ValidationRule
{

    private string $enum;

    /**
     * Create a new rule instance.
     *
     * @param string $enum
     */
    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, array_column($this->enum::cases(), 'value'))) {
            $fail(__('The selected :attribute is invalid.'));
        }
    }
}
