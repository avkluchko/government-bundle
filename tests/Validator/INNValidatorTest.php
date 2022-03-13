<?php

namespace AVKluchko\GovernmentBundle\Tests\Validator;

use AVKluchko\GovernmentBundle\Validator\INNValidator;
use PHPUnit\Framework\TestCase;

class INNValidatorTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        $this->validator = new INNValidator();
    }

    /**
     * @dataProvider provideINNValues
     *
     * @param string $value
     * @param bool $expected
     */
    public function testIsValid(string $value, bool $expected): void
    {
        self::assertEquals($this->validator->isValid($value), $expected);
    }

    public function provideINNValues(): array
    {
        return [
            ['', false],
            ['          ', false], // 10 whitespaces
            ['abcd156789', false], // non digits
            ['22345678915', false], // wrong count digits
            ['2234567891533', false], // wrong count digits

            ['1145678579', false],
            ['1145678569', false],
            ['1145678578', true],

            ['114567857921', false],
            ['114564878569', false],
            ['164400537302', true],

            ['103008227', true],
            ['0103008227', true],
            ['00103008227', true],
            ['000103008227', true],
        ];
    }

    /**
     * @dataProvider provideControlSumValues
     *
     * @param string $value
     * @param array $coefficients
     * @param int $expected
     */
    public function testGetControlSum(string $value, array $coefficients, int $expected): void
    {
        self::assertEquals($this->validator->getControlSum($value, $coefficients), $expected);
    }

    public function provideControlSumValues(): array
    {
        return [
            ['1234567890', INNValidator::C10, 4],
            ['9876054321', INNValidator::C10, 2],
            ['98760543219', INNValidator::C11, 7],
            ['123123789012', INNValidator::C12, 9],
        ];
    }

    public function testNormalizeLength(): void
    {
        self::assertEquals('064400537302', $this->validator->normalizeLength('064400537302'));
        self::assertEquals('064400537302', $this->validator->normalizeLength('64400537302'));

        self::assertEquals('0103008227', $this->validator->normalizeLength('103008227'));
        self::assertEquals('0103008227', $this->validator->normalizeLength('0103008227'));
        self::assertEquals('0103008227', $this->validator->normalizeLength('00103008227'));
        self::assertEquals('0103008227', $this->validator->normalizeLength('000103008227'));
    }
}
