<?php

namespace App\Interfaces;

use Illuminate\Database\Query\Builder;
use App\Repositories\TransactionRepository;
use App\Repositories\AccountRepository;


interface TransactionServiceInterface{

    public function modelQuery();
    public function createTransaction(TransactionRepository $transactionRepository);
    public function generateReference();
    public function getTransactionByReference();
    public function getTransactionById();
    public function getTransactionsByAccountNumber();
    public function getTransactionsByUserId();
    public function downloadTransactionHistory(AccountRepository $accountRepository, $fromDate, $endDate);
    public function updateTransactionBalance($reference,$balance);
}


