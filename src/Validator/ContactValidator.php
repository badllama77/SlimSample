<?php

namespace ESoft\SlimSample\Validator;

use Respect\Validation\Validator;

class ContactValidator extends BaseValidator
{
    protected $fields = ['first_name'=>'',
        'last_name'=>'',
        'email'=>'',
        'addresses'=>'',
        'phone_numbers'=>''];
    public function validate()
    {
        $this->target = array_merge($this->fields, $this->target);
        return $this->validateFirstName($this->target['first_name']) &&
        $this->validateLastName($this->target['last_name']) &&
        $this->validateEmail($this->target['email']) &&
        $this->validateAddresses($this->target['addresses']) &&
        $this->validatePhoneNumbers($this->target['phone_numbers']);
    }

    public function validateFirstName($firstName)
    {
        return $this->validateField(Validator::notEmpty(), $firstName, 'firstName');
    }

    public function validateLastName($lastName)
    {
        return $this->validateField(Validator::notEmpty(), $lastName, 'lastName');
    }

    public function validateEmail($email)
    {
        return $this->validateField(Validator::notEmpty()->email(), $email, 'email');
    }

    public function validateAddresses($addresses)
    {
        return $this->validateNestedField($addresses, 'ESoft\SlimSample\Validator\AddressValidator', 'addresses');
    }

    public function validatePhoneNumbers($phoneNumbers)
    {
        return $this->validateNestedField($phoneNumbers, 'ESoft\SlimSample\Validator\PhoneNumberValidator', 'phoneNumbers');
    }
}
