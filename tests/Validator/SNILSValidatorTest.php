<?php

namespace AVKluchko\GovernmentBundle\Tests\Validator;

use AVKluchko\GovernmentBundle\Validator\OGRNValidator;
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

            ['12345678983', true],
            ['123-456-789-83', true],
            ['123-456-789 83', true],
            ['123 456 789 83', true],

            ['001 001 998 01', false],
            ['001 001 999 23', true],

            ['555-444-333 61', true],
        ];
    }

    public function testGetControlSum(): void
    {
        self::assertEquals('71', $this->validator->getControlSum('321654987'));
        self::assertEquals('11', $this->validator->getControlSum('468135357'));
        self::assertEquals('54', $this->validator->getControlSum('112233445'));
    }
}