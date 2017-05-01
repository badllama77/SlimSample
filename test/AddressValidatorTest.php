<?php

namespace ESoft\SlimSample;

use ESoft\SlimSample\Validator\AddressValidator;
use PHPUnit\Framework\TestCase;

class AddressValidatorTest extends TestCase
{
    /**
     * Test empty condition for street validation function
     * @covers ESoft\SlimSample\ContactValidator::validateStreet
     * @return void
     */
    public function testReturnsFalseWhenStreetIsEmpty()
    {
        $validator = new AddressValidator();
        $this->assertFalse($validator->validateStreet(''));
    }

    /**
     * Test valid condition for street validation function
     * @covers ESoft\SlimSample\ContactValidator::validateStreet
     * @return void
     */
    public function testReturnsTrueWhenStreetIsValid()
    {
        $validator = new AddressValidator();
        $this->assertTrue($validator->validateStreet('221B Baker St.'));
    }

    /**
     * Test empty condition for city validation function
     * @covers ESoft\SlimSample\ContactValidator::validateCity
     * @return void
     */
    public function testReturnsFalseWhenCityIsEmpty()
    {
        $validator = new AddressValidator();
        $this->assertFalse($validator->validateCity(''));
    }

    /**
     * Test valid condition for city validation function
     * @covers ESoft\SlimSample\ContactValidator::validateCity
     * @return void
     */
    public function testReturnsTrueWhenCityIsValid()
    {
        $validator = new AddressValidator();
        $this->assertTrue($validator->validateCity('Newark'));
    }

    /**
     * Test empty condition for state validation function
     * @covers ESoft\SlimSample\ContactValidator::validateState
     * @return void
     */
    public function testReturnsFalseWhenStateIsEmpty()
    {
        $validator = new AddressValidator();
        $this->assertFalse($validator->validateState(''));
    }

    /**
     * Test valid condition for state validation function
     * @covers ESoft\SlimSample\ContactValidator::validateState
     * @return void
     */
    public function testReturnsTrueWhenStateIsValid()
    {
        $validator = new AddressValidator();
        $this->assertTrue($validator->validateState('New Jersey'));
    }

    /**
     * Test empty condition for zipcode validation function
     * @covers ESoft\SlimSample\ContactValidator::validateZipcode
     * @return void
     */
    public function testReturnsFalseWhenZipcodeIsEmpty()
    {
        $validator = new AddressValidator();
        $this->assertFalse($validator->validateZipcode(''));
    }

    /**
     * Test valid condition for zipcode validation function
     * @covers ESoft\SlimSample\ContactValidator::validateZipcode
     * @return void
     */
    public function testReturnsTrueWhenZipcodeIsValid()
    {
        $validator = new AddressValidator();
        $this->assertTrue($validator->validateZipcode('k9j 843'));
    }
}
