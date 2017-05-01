<?php

namespace ESoft\SlimSample\Validator;

use Respect\Validation\Validator;

class PhoneNumberValidator extends BaseValidator
{
    public function validate()
    {
        return $this->validateField(Validator::notEmpty()->phone(), $this->target['number'], 'number');
    }
}
