<?php

namespace ESoft\SlimSample\Exception;

class InvalidContactException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
