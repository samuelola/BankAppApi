<?php

namespace App\Services;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Repositories\TransactionRepository;
use App\Repositories\AccountRepository;
use App\Interfaces\TransactionServiceInterface;
use App\Enum\TransactionCategoryEnum;
use App\Models\Transaction;

class TransactionService implements TransactionServiceInterface
{

    public function modelQuery()
    {
       return Transaction::query();
    }

    public function generateReference()
    {
        return Str::upper('TF'. '/' . Carbon::now()->getTimestampMs() . '/' . Str::random(4));
    }

    
    public function createTransaction($transactionRepo)
    {    
        
        $transactionRepository = new TransactionRepository(); 
        $data = [];
        $data = $transactionRepository->forTransactionToArray($transactionRepo);
        $transaction = $this->modelQuery()->create($data);
        return $transaction;
    }


    public function getTransactionByReference()
    {

    }
    public function getTransactionById()
    {

    }
    public function getTransactionsByAccountNumber()
    {

    }
    public function getTransactionsByUserId()
    {

    }
    public function downloadTransactionHistory(AccountRepository $accountRepository,$fromDate,$endDate)
    {

    }
    
    public function updateTransactionBalance($reference, $balance)
    {
        $this->modelQuery()->where('reference',$reference)->update(
            [
                'balance'=>$balance,
                'confirmed'=>true
            ]);
    }

    public function updateTransferId($reference, $transferId)
    {
        $this->modelQuery()->where('reference',$reference)->update(
            [
                'transfer_id'=>$transferId,
            ]);
    }
}