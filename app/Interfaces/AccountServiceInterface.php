<?php

namespace App\Interfaces;

use Illuminate\Database\Query\Builder;
use App\Repositories\UserRepository;
use App\Repositories\DepositRepository;
use App\Repositories\WithdrawRepository;
use App\Repositories\TransferRepository;
use App\Services\TransactionService;

interface AccountServiceInterface{

    public function modelQuery();
    public function createAccountNumber(UserRepository $userRepositories);
    public function getAccountByAccountNumber(string $accountNumber);
    public function getAccountByUserId(int $userId);
    public function getAccount(int|string $accountNumberOrUserId);
    //public function deposit(DepositRepositiory $depositRepository);
    public function deposit(DepositRepository $depositRepository, TransactionService $transactionService);
    public function accountExist($accountQuery);
    public function withdraw(WithdrawRepository $withdrawRepository,TransactionService $transactionService);
    public function canWithdraw($accountRepo,$withdrawRepository);
    public function transfer(string $senderAccountNumber,$senderAccountPin, string $receiverAccountNumber, int|float $amount, string $description=null);

}