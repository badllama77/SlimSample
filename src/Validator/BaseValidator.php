<?php

namespace ESoft\SlimSample\Validator;

use Respect\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;

abstract class BaseValidator
{
    protected $target;
    protected $messages;

    public function __construct($target = [])
    {
        $this->target = $target;
        $this->messages = [];
    }

    abstract public function validate();

    public function getMessages()
    {
        return $this->messages;
    }

    protected function validateField(Validator $v, $value, $field)
    {
        try {
            $v->assert($value);
            return true;
        } catch (NestedValidationException $e) {
            $this->messages[$field] = $e->getMessages();
            return false;
        }
    }
}
