<?php

namespace AVKluchko\GovernmentBundle\Validator;

class INNValidator
{
    public const C10 = [2, 4, 10, 3, 5, 9, 4, 6, 8];
    public const C11 = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
    public const C12 = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8];

    public function isValid(string $value): bool
    {
        $value = trim($value);

        if ($value === '') {
            return false;
        }

        if (!preg_match('/^\d{9,12}$/', $value)) {
            return false;
        }

        $value = $this->normalizeLength($value);

        if (strlen($value) === 12) {
            $sum11 = $this->getControlSum($value, self::C11);
            $sum12 = $this->getControlSum($value, self::C12);

            return $sum11 === (int)$value[10] && $sum12 === (int)$value[11];
        }

        $sum = $this->getControlSum($value, self::C10);

        return $sum === (int)$value[9];

    }

    public function normalizeLength($value): string
    {
        $value = str_pad($value, 12, '0', STR_PAD_LEFT);

        if ($value[0] === '0' && $value[1] === '0') {
            $value = substr($value, 2, 12);
        }

        return $value;
    }

    /**
     * Calculate INN control sum for different coefficients
     *
     * @param string $value
     * @param array $coefficients
     * @return int
     */
    public function getControlSum(string $value, array $coefficients): int
    {
        $sum = 0;

        foreach ($coefficients as $i => $c) {
            $sum += $c * (int)$value[$i];
        }

        return $sum % 11 % 10;
    }
}