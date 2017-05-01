<?php

namespace ESoft\SlimSample\Validator;

use Respect\Validation\Validator;
use ESoft\SlimSample\Model\Address;
use Respect\Validation\Exceptions\NestedValidationException;

class AddressValidator extends BaseValidator
{
    public function validate()
    {
        return $this->validateStreet($this->target['street_line1']) &&
        $this->validateCity($this->target['city']) &&
        $this->validateState($this->target['state']) &&
        $this->validateZipcode($this->target['zipcode']);
    }

    public function validateStreet($street)
    {
         return $this->validateField(Validator::notEmpty(), $street, 'street_line1');
    }

    public function validateCity($city)
    {
         return $this->validateField(Validator::notEmpty(), $city, 'city');
    }

    public function validateState($state)
    {
         return $this->validateField(Validator::notEmpty(), $state, 'state');
    }

    public function validateZipcode($zipcode)
    {
         return $this->validateField(Validator::notEmpty(), $zipcode, 'zipcode');
    }
}
