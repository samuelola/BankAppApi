<?php

namespace App\Interfaces;

use Illuminate\Database\Query\Builder;
use App\Repositories\TransferRepository;
use App\Repositories\AccountRepository;


interface TransferServiceInterface{

    public function modelQuery();
    public function createTransfer(TransferRepository $transferRepository);
    public function generateReference();
    // public function getTransferBetweenAccount(AccountRepository $accountRepository);
    public function getTransferById(int $transferId);
    public function getTransferByReference(string $reference);
    
}


