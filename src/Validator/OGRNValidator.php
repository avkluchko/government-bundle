<?php

namespace AVKluchko\GovernmentBundle\Validator;

class OGRNValidator
{
    public function isValid(string $value): bool
    {
        $value = trim($value);

        if (!in_array(strlen($value), [13, 15]) || !ctype_alnum($value)) {
            return false;
        }

        if (!in_array($value[0], [1, 3, 5])) {
            return false;
        }

        $year = substr($value, 1, 2);
        if ($year < 2 || $year > date('y')) {
            return false;
        }

        // If use x32 php -> skip control number validation
        if ($value > PHP_INT_MAX) {
            return true;
        }

        return $this->checkControlNumber($value);
    }

    /**
     * Check last control number on 32 bit system.
     * For this need BCMath extension
     */
    public function checkControlNumber(string $value): bool
    {
        $length = strlen($value);
        $main = substr($value, 0, $length - 1);

        $expectedControl = substr($value, -1);
        $realControl = substr(strval($main % ($length - 2)), -1);

        return $realControl === $expectedControl;
    }
}
