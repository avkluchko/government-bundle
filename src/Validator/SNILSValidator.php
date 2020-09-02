<?php

namespace AVKluchko\GovernmentBundle\Validator;

class SNILSValidator
{
    public function isValid(string $value): bool
    {
        $value = trim($value);

        if (preg_match('/^(\d{3}[\-\s]?\d{3}[\-\s]?\d{3})[\-\s]?(\d{2})$/', $value, $matches)) {
            if (!isset($matches[1], $matches[2])) {
                return false;
            }

            $number = str_replace(['-', ' '], '', $matches[1]);
            $control = (int)$matches[2];

            if ((int)$number <= 1001998) {
                return false;
            }

            return $control === $this->getControlSum($number);
        }

        return false;
    }

    /**
     * @param string $value
     * @return int
     */
    public function getControlSum(string $value): int
    {
        $sum = 0;

        $len = strlen($value);
        for ($i = 1; $i <= $len; $i++) {
            $sum += $i * $value[$len - $i];
        }

        while ($sum > 100) {
            $sum %= 101;
        }

        return $sum === 100 ? 0 : $sum;
    }
}