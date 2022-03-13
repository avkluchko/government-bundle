<?php

namespace AVKluchko\GovernmentBundle\Tests\Validator;

use AVKluchko\GovernmentBundle\Validator\SNILSValidator;
use PHPUnit\Framework\TestCase;

class SNILSValidatorTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        $this->validator = new SNILSValidator();
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
            ['         ', false], // 13 whitespaces
            ['abcd1234521', false],

            ['12345678964', true],
            ['123-456-789-64', true],
            ['123-456-789 64', true],
            ['123 456 789 64', true],

            ['001 001 998 01', false],
            ['001 001 999 65', true],

            ['555-444-333 97', true],
        ];
    }

    public function testGetControlSum(): void
    {
        self::assertEquals('64', $this->validator->getControlSum('123456789'));
        self::assertEquals('65', $this->validator->getControlSum('001001999'));
        self::assertEquals('97', $this->validator->getControlSum('555444333'));
        self::assertEquals('76', $this->validator->getControlSum('321654987'));
        self::assertEquals('5', $this->validator->getControlSum('468135357'));
        self::assertEquals('95', $this->validator->getControlSum('112233445'));
    }
}
