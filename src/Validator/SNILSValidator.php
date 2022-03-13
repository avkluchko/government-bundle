<?php

namespace AVKluchko\GovernmentBundle\Validator;

class SNILSValidator
{
    /**
     * Минимально допустимый возможный номер без контрольного числа,
     * например, 001-001-999 01
     */
    private const MIN_ALLOWED_NUMBER = 1001999;

    public function isValid(string $value): bool
    {
        $value = trim($value);

        if (preg_match('/^(\d{3}[\-\s]?\d{3}[\-\s]?\d{3})[\-\s]?(\d{2})$/', $value, $matches)) {
            if (!isset($matches[1], $matches[2])) {
                return false;
            }

            $number = str_replace(['-', ' '], '', $matches[1]);
            $control = intval($matches[2]);

            if (intval($number) < self::MIN_ALLOWED_NUMBER) {
                return false;
            }

            return $control === $this->getControlSum($number);
        }

        return false;
    }

    public function getControlSum(string $value): int
    {
        $sum = 0;

        $len = strlen($value);
        for ($i = 1; $i <= $len; $i++) {
            $sum += $i * intval($value[$len - $i]);
        }

        while ($sum > 100) {
            $sum %= 101;
        }

        return $sum === 100 ? 0 : $sum;
    }
}
