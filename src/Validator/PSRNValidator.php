<?php

namespace AVKluchko\GovernmentBundle\Validator;

class PSRNValidator
{
    public function isValid(string $value): bool
    {
        $value = trim($value);

        if (!preg_match('/^\d{13}$/', $value)) {
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
     *
     * @param string $value
     * @return bool
     */
    public function checkControlNumber(string $value): bool
    {
        $length = strlen($value);
        $main = substr($value, 0, $length - 1);

        $expectedControl = substr($value, -1);
        $realControl = substr($main % ($length - 2), -1);

        return $realControl === $expectedControl;
    }
}