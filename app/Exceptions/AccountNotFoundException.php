<?php

namespace App\Exceptions;

use Exception;

class AccountNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Account Number Not found");
    }
}
