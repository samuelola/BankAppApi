<?php

namespace App\Exceptions;

use Exception;

class InsuffientBalanceException extends Exception
{
    public function __construct()
    {
        parent::__construct("Insuffient Balance");
    }
}
