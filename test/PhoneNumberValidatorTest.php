<?php

namespace ESoft\SlimSample;

use ESoft\SlimSample\Validator\PhoneNumberValidator;
use PHPUnit\Framework\TestCase;

class ContactValidatorTest extends TestCase
{
    public function testReturnsTrueWhenPhoneNumberIsValid()
    {
        $validator = new PhoneNumberValidator(['phone_type'=>'home', 'number'=>'555-555-1234']);
        $this->assertTrue($validator->validate());
        $validator = new PhoneNumberValidator(['phone_type'=>'home', 'number'=>'555.555.1234']);
        $this->assertTrue($validator->validate());
        $validator = new PhoneNumberValidator(['phone_type'=>'home', 'number'=>'555 555 1234']);
        $this->assertTrue($validator->validate());
    }

    public function testReturnsFalseWhenPhoneNumberIsInvalid()
    {
        $validator = new PhoneNumberValidator(['phone_type'=>'home', 'number'=>'IAMAPHONE']);
        $this->assertFalse($validator->validate());
    }

    public function testReturnsFalseWhenPhoneNumberIsEmpty()
    {
        $validator = new PhoneNumberValidator(['phone_type'=>'home', 'number'=>'']);
        $this->assertFalse($validator->validate());
    }
}
