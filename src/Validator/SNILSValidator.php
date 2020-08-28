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

        for ($i = strlen($value); $i > 0; $i--) {
            $sum += $i * $value[$i - 1];
        }

        while ($sum > 101) {
            $sum %= 101;
        }

        if ($sum === 100 || $sum === 101) {
            return 0;
        }

        return $sum;
    }
}