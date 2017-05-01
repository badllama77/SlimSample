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

    public static function createValidator($class, $data)
    {
        return new $class($data);
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

    protected function validateNestedField($targets, $validatorClass, $field)
    {
        $result = true;
        if (!is_array($targets)) {
            return $result;
        }
        foreach ($targets as $key => $target) {
            $validator = self::createValidator($validatorClass, $target);
            if (!$validator->validate()) {
                $result = false;
                $this->messages["$field"][$key] = $this->getMessages();
            }
        }
        return $result;
    }
}
