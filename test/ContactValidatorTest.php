<?php

namespace ESoft\SlimSample;

use ESoft\SlimSample\Validator\ContactValidator;
use PHPUnit\Framework\TestCase;

class ContactValidatorTest extends TestCase
{
    /**
     * Test valid condition for email validation function
     * @covers ESoft\SlimSample\ContactValidator::validateEmail
     * @return void
     */
    public function testReturnsTrueWhenEmailIsValid()
    {
        $validator = new ContactValidator();
        $this->assertTrue($validator->validateEmail('test@nowhere.com'));
    }

    /**
     * Test invalid condistion for email validation function
     * @covers ESoft\SlimSample\ContactValidator::validateEmail
     * @return void
     */
    public function testReturnsFalseWhenEmailIsInvalid()
    {
        $validator = new ContactValidator();
        $this->assertFalse($validator->validateEmail('testnowhere.com'));
    }

    /**
     * Test empty condition for email validation function
     * @covers ESoft\SlimSample\ContactValidator::validateEmail
     * @return void
     */
    public function testReturnsFalseWhenEmailIsEmpty()
    {
        $validator = new ContactValidator();
        $this->assertFalse($validator->validateEmail(''));
    }

    /**
     * Test empty condition for first name validation function
     * @covers ESoft\SlimSample\ContactValidator::validateFirstName
     * @return void
     */
    public function testReturnsFalseWhenFirstNameIsEmpty()
    {
        $validator = new ContactValidator();
        $this->assertFalse($validator->validateFirstName(''));
    }

    /**
     * Test valid condition for first name validation function
     * @covers ESoft\SlimSample\ContactValidator::validateFirstName
     * @return void
     */
    public function testReturnsTrueWhenFirstNameIsValid()
    {
        $validator = new ContactValidator();
        $this->assertTrue($validator->validateFirstName('Rick'));
    }

    /**
     * Test empty condition for first name validation function
     * @covers ESoft\SlimSample\ContactValidator::validateFirstName
     * @return void
     */
    public function testReturnsFalseWhenLastNameIsEmpty()
    {
        $validator = new ContactValidator();
        $this->assertFalse($validator->validateLastName(''));
    }

    /**
     * Test valid condition for first name validation function
     * @covers ESoft\SlimSample\ContactValidator::validateFirstName
     * @return void
     */
    public function testReturnsTrueWhenLastNameIsValid()
    {
        $validator = new ContactValidator();
        $this->assertTrue($validator->validateLastName('Sanchez'));
    }
}
