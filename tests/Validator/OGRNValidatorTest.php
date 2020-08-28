<?php

namespace AVKluchko\GovernmentBundle\Tests\Validator;

use AVKluchko\GovernmentBundle\Validator\OGRNValidator;
use PHPUnit\Framework\TestCase;

class OGRNValidatorTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        $this->validator = new OGRNValidator();
    }

    /**
     * @dataProvider provideValues
     *
     * @param string $value
     * @param bool $expected
     */
    public function testIsValid(string $value, bool $expected): void
    {
        self::assertEquals($this->validator->isValid($value), $expected);
    }

    public function provideValues(): array
    {
        return [
            ['', false],
            ['             ', false], // 13 whitespaces
            ['abcd123456789', false],
            ['2234567891577', false], // wrong first digit
            ['1014567891579', false], // wrong year (less then 2002)
            ['1324567891579', false], // wrong year (more then current year)
            ['1124567891577', false], // wrong control sum
            ['103456789157', false],  // wrong length
            ['1034567891577', true],
            ['1134567891590', true],
            ['1115038000263', true], // real psrn (ogrn)
            ['5077746605822', true], // real psrn (ogrn)
        ];
    }
}