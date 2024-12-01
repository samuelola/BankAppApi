<?php

namespace App\Exceptions;

use Exception;

class AmountTooLowForWithdrawalException extends Exception
{
    public function __construct($amount)
    {
        parent::__construct("Withdrawal amount must be greater than or equal to ".$amount);
    }
}
