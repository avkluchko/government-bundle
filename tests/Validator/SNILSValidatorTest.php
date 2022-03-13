<?php

namespace AVKluchko\GovernmentBundle\Tests\Validator;

use AVKluchko\GovernmentBundle\Validator\SNILSValidator;
use PHPUnit\Framework\TestCase;

class SNILSValidatorTest extends TestCase
{
    private SNILSValidator $validator;

    public function setUp(): void
    {
        $this->validator = new SNILSValidator();
    }

    public function testIsValid(): void
    {
        self::assertEquals(false, $this->validator->isValid(''));
        self::assertEquals(false, $this->validator->isValid('         '));

        self::assertEquals(false, $this->validator->isValid('abcd1234521'));
        self::assertEquals(true, $this->validator->isValid('12345678964'));
        self::assertEquals(true, $this->validator->isValid('123-456-789-64'));
        self::assertEquals(true, $this->validator->isValid('123-456-789 64'));
        self::assertEquals(true, $this->validator->isValid('123 456 789 64'));

        self::assertEquals(false, $this->validator->isValid('001 001 998 01'));
        self::assertEquals(true, $this->validator->isValid('001 001 999 65'));

        self::assertEquals(true, $this->validator->isValid('555-444-333 97'));
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
