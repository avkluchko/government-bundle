<?php

namespace AVKluchko\GovernmentBundle\Tests\Validator;

use AVKluchko\GovernmentBundle\Validator\PSRNValidator;
use PHPUnit\Framework\TestCase;

class PSRNValidatorTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        $this->validator = new PSRNValidator();
    }

    /**
     * @dataProvider provideValues
     */
    public function testIsValid(string $value, bool $expected)
    {
        $this->assertEquals($this->validator->isValid($value), $expected);
    }

    public function provideValues(): array
    {
        return [
            ['', false],
            ['             ', false], // 13 whitespaces
            ['abcd123456789', false],
            ['1234567891577', false],
            ['1234567891579', true],
            ['1234567891580', true],
        ];
    }
}