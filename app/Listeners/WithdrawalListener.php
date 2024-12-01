<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\WithdrawalEvent;
use App\Services\TransactionService;
use App\Enum\TransactionCategoryEnum;

class WithdrawalListener
{
    /**
     * Create the event listener.
     */

    public $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Handle the event.
     */
    public function handle(WithdrawalEvent $event): void
    {
        
        if($event->transactionRepo->getCategory() == TransactionCategoryEnum::WITHDRAWAL->value){
        $this->transactionService->createTransaction($event->transactionRepo);
        $account = $event->lockedAccount;
        $account->balance = $account->balance - $event->transactionRepo->getAmount();
        $account->save();
        $account = $account->refresh();
        // update balance 
        $this->transactionService->updateTransactionBalance($event->transactionRepo->getReference(),$account->balance);
        }else{
            $this->transactionService->createTransaction($event->transactionRepo);
        $account = $event->lockedAccount;
        $account->balance = $account->balance + $event->transactionRepo->getAmount();
        $account->save();
        // this gives you the account details
        $account = $account->refresh();
        // update balance 
        $this->transactionService->updateTransactionBalance($event->transactionRepo->getReference(),$account->balance);
        if($event->transactionRepo->getTransferId()){
             $this->transactionService->updateTransferId($event->transactionRepo->getReference(),$event->transactionRepo->getTransferId());
        }
        }
        
        
        
    }
}
