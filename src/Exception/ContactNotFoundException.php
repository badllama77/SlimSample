<?php

namespace ESoft\SlimSample\Exception;

class ContactNotFoundException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
