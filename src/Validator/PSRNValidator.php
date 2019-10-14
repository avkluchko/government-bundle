<?php

namespace AVKluchko\GovernmentBundle\Validator;

class PSRNValidator
{
    public function isValid(string $value): bool
    {
        $value = trim($value);
        $length = strlen($value);

        if ($length !== 13) {
            return false;
        }

        if (!preg_match('/\d{13}/', $value)) {
            return false;
        }

        $number = (int)substr($value, 0, $length - 1);
        $controlNumber = (int)substr($value, $length - 1);
        $result = (string)$number % ($length - 2);
        $lastNumber = (int)substr($result, strlen($result) - 1);

        var_dump($lastNumber);
        var_dump($controlNumber);

        return $lastNumber === $controlNumber;
    }
}