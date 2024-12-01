<?php

namespace App\Repositories;

use App\Enum\TransactionCategoryEnum;
use Carbon\Carbon;

class TransactionRepository
{
    
    private int $id;
    private string $reference;
    private int $user_id;
    private int $account_id;
    private ?int $transfer_id = null;
    private float $amount;
    private float $balance;
    public ?string $category = null;
    private string $metal;
    private ?string $description = null;
    private Carbon $date;
    private bool $confirmed;
    private Carbon $created_at;
    private Carbon $updated_at;




    public function getId(){
       return $this->id;
    }

    public function setId($id){
         return $this->id = $id;
    }

    public function getReference(){
        return $this->reference;
    }

    public function setReference($reference){
           return $this->reference = $reference;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function setUserId($user_id){
         return $this->user_id = $user_id;
    }

    public function getAccountId(){
        return $this->account_id;
    }

    public function setAccountId($account_id){
       return $this->account_id = $account_id;
    }
    public function getTransferId(){
       return $this->transfer_id;
    }

    public function setTransferId($transfer_id){
         return $this->transfer_id = $transfer_id;
    }
    public function getAmount(){
       return $this->amount;
    }

    public function setAmount($amount){
        return $this->amount = $amount;
    }
    public function getBalance(){
       return $this->balance;
    }

    public function setBalance($balance){
       return $this->balance = $balance;
    }
    public function getCategory(){
        return $this->category;
    }

    public function setCategory($category){
       return $this->category =  $category;
       
    }
    public function getMetal(){
        return $this->metal;
    }

    public function setMetal($metal){
        return $this->metal = $metal;
    }
    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        return $this->description = $description;
    }
    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
         return $this->date = $date;
    }
    public function getConfirmed(){
        return $this->confirmed;
    }

    public function setConfirmed($confirmed){
       return $this->confirmed = $confirmed;
    }
    public function getCreatedAt(){
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at){
        return $this->updated_at = $updated_at;
    }
    

    public function forDeposit(AccountRepository $accountRepository,DepositRepository $depositRepository,string $reference)
    {
        $tranx = new TransactionRepository();
        $tranx->setUserId($accountRepository->getUserId());
        $tranx->setReference($reference);
        $tranx->setAccountId($accountRepository->getId());
        $tranx->setAmount($depositRepository->getAmount());
        $tranx->setDate(Carbon::now());
        $tranx->setCategory($depositRepository->getCategory());
        $tranx->setDescription($depositRepository->getDescription());
        return $tranx;
    }

    public function forTransactionToArray($transactionRepository)
    {

        return [
             'user_id' => $transactionRepository->user_id,
             'reference' => $transactionRepository->reference,
             'account_id' => $transactionRepository->account_id,
             'amount' => $transactionRepository->amount,
             'category' => $transactionRepository->getCategory(),
             'date' => Carbon::now(),
             'description' => $transactionRepository->description,

        ];
    }

   
    public function forWithdrawal(AccountRepository $accountRepository,WithdrawRepository $withdrawalRepository,string $reference)
    {
        $tranx = new TransactionRepository();
        $tranx->setUserId($accountRepository->getUserId());
        $tranx->setReference($reference);
        $tranx->setAccountId($accountRepository->getId());
        $tranx->setAmount($withdrawalRepository->getAmount());
        $tranx->setDate(Carbon::now());
        $tranx->setCategory($withdrawalRepository->getCategory());
        $tranx->setDescription($withdrawalRepository->getDescription());
        return $tranx;

    }

    
}