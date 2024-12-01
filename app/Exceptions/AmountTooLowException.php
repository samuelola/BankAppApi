<?php

namespace App\Exceptions;

use Exception;

class AmountTooLowException extends Exception
{
    public function __construct($amount)
    {
        parent::__construct("Deposit amount must be greater than ".$amount);
    }
}
