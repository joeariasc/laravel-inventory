<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Ean8 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidEan8($value)) {
            $fail('The :attribute must be a valid EAN-8 code.');
        }
    }

    /**
     * Validate the EAN-8 barcode.
     *
     * @param string $code
     * @return bool
     */
    protected function isValidEan8(string $code): bool
    {
        if (!preg_match('/^\d{8}$/', $code)) {
            return false;
        }

        $checkDigit = (int)$code[7];
        $sum = 0;

        for ($i = 0; $i < 7; $i++) {
            $sum += $code[$i] * (($i % 2 === 0) ? 3 : 1);
        }

        $calculatedCheckDigit = (10 - ($sum % 10)) % 10;

        return $checkDigit === $calculatedCheckDigit;
    }
}
