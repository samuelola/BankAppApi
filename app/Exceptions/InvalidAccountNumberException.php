<?php

namespace App\Exceptions;

use Exception;

class InvalidAccountNumberException extends Exception
{
    public function __construct()
    {
        parent::__construct("Account Number does not exist");
    }
}
