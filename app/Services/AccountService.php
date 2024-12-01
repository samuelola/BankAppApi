<?php

namespace App\Services;

use App\Interfaces\AccountServiceInterface;
use App\Models\Account;
use App\Repositories\UserRepository;
use App\Repositories\AccountRepository;
use App\Repositories\DepositRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TransferRepository;
use App\Exceptions\AccountNumberExistException;
use DB;
use App\Events\DepositEvent;
use App\Events\WithdrawalEvent;
use App\Exceptions\AmountTooLowException;
use App\Exceptions\InvalidAccountNumberException;
use App\Repositories\WithdrawRepository;
use App\Exceptions\InvalidPinException;
use App\Exceptions\InsuffientBalanceException;
use App\Exceptions\AccountNotFoundException;
use App\Exceptions\AmountTooLowForWithdrawalException;


class AccountService implements AccountServiceInterface
{
    public function modelQuery()
    {
       return Account::query();
    }

    public function getAccountByUserId($userId)
    {
        return $this->modelQuery()->where('user_id',$userId)->first();
    }

    public function hasAccountNumber(UserRepository $UserRepository): bool
    {
        return $this->modelQuery()->where('user_id',$UserRepository->getId())->exists();
        
    }

    public function createAccountNumber(UserRepository $UserRepository)
    {
        if($this->hasAccountNumber($UserRepository)){
           throw new AccountNumberExistException("Account Number Already created!");
        }
       return $this->modelQuery()->create([
          'account_number'=>substr($UserRepository->getPhoneNumber(),-10),
          'user_id' => $UserRepository->getId()
       ]);
    }
    public function getAccountByAccountNumber(string $accountNumber)
    {

    }

    

    public function getAccount(int|string $accountNumberOrUserId)
    {

    }

    public function deposit(DepositRepository $depositRepository, TransactionService $transactionService){
       
        $minimum_deposit = 500;
        if($depositRepository->getAmount() < $minimum_deposit){
            throw new AmountTooLowException($minimum_deposit);
        }

        try{
           DB::beginTransaction();
           $accountQuery = $this->modelQuery()->where('account_number',$depositRepository->getAccountNumber());
           $this->accountExist($accountQuery);
           //Note locked account is the account we want to deposit money into (accounts  table)
           $lockedAccount = $accountQuery->lockForUpdate()->first();
           $accountRepo = AccountRepository::fromModel($lockedAccount);
           $transactionRepo =  (new TransactionRepository())->forDeposit(
           $accountRepo,
           $depositRepository,
           $transactionService->generateReference(),
         );
           event(new DepositEvent($transactionRepo,$accountRepo,$lockedAccount));
           DB::commit();
        }catch(\Exception $exception){
           DB::rollback();
           throw $exception;
        }
    }

    public function accountExist($accountQuery)
    {
          if($accountQuery->exists() == false){
             throw new InvalidAccountNumberException();
          }
          return true;
    }

    public function withdraw(WithdrawRepository $withdrawRepository,TransactionService $transactionService){
         
      //check for the minimium withdrawal
         $minimum_withdrawal = 100;
         if($withdrawRepository->getAmount() < $minimum_withdrawal){
            throw new AmountTooLowForWithdrawalException($minimum_withdrawal);
         }
         $userService = new UserService();
         try{
           DB::beginTransaction();
           // check for the account number existence
            $accountQuery = $this->modelQuery()->where('account_number',$withdrawRepository->getAccountNumber());
            $this->accountExist($accountQuery);
            // if account is present lock for update
            $lockedAccount = $accountQuery->lockForUpdate()->first();
            $accountRepo = AccountRepository::fromModel($lockedAccount);
            //check if the user account exist
            if($this->getAccountByUserId($accountRepo->getUserId())->account_number == NULL){
               throw new AccountNotFoundException();
            }
            
            // check if the user pin is valid
            if(!$userService->validatePin($accountRepo->getUserId(),$withdrawRepository->getPin())){
                throw new InvalidPinException();
            }
            //check if the user can withdraw
            $this->canWithdraw($accountRepo,$withdrawRepository);
            
               $transactionRepoWithdrawal =  (new TransactionRepository())->forWithdrawal(
               $accountRepo,
               $withdrawRepository,
               $transactionService->generateReference()
            );
            
            //use event to decouple what is happen in an event
            event(new WithdrawalEvent($transactionRepoWithdrawal,$accountRepo,$lockedAccount));
            
           DB::commit();
         }catch(\Exception $e){
           
            DB::rollback();
            throw $e;
         }
    }

    public function transfer(string $senderAccountNumber,$senderAccountPin, string $receiverAccountNumber, int|float $amount, string $description=null)
    {

         if($senderAccountNumber == $receiverAccountNumber){
            throw new \Exception("Receiver and Sender Account Number can not be the same");
         }
       //check for the minimium withdrawal
         $minimum_withdrawal = 300;
         
         try{
             DB::beginTransaction();
             $senderaccountquery = $this->modelQuery()->where('account_number',$senderAccountNumber);
             $receiveraccountquery = $this->modelQuery()->where('account_number',$receiverAccountNumber);
             //check if the two account number exists
             $this->accountExist($senderaccountquery);
             $this->accountExist($receiveraccountquery);

             //retrieve a locked version of the sender or reciever account number
             $lockedsenderAccount = $senderaccountquery->lockForUpdate()->first();
             $lockedreceiverAccount = $receiveraccountquery->lockForUpdate()->first();
            
             $senderaccountRepo = AccountRepository::fromModel($lockedsenderAccount);
             
             $receiveraccountRepo = AccountRepository::fromModel($lockedreceiverAccount);
               
               // for sender
               $withdrawDto = new WithdrawRepository();
               // for receiver
               $depositDto = new DepositRepository();
               // for transfer
               $transferDto = new TransferRepository();
               // for transaction
               $transactionService = new TransactionService();
               $transactionDto = new TransactionRepository();
               $transferService = new TransferService();
               $userService = new UserService();

                //validate the sender pin
               if(!$userService->validatePin($senderaccountRepo->getUserId(),$senderAccountPin)){
                  throw new InvalidPinException();
               }
               
               $withdrawDto->setAccountNumber($lockedsenderAccount->account_number);
               $withdrawDto->setAmount($amount);
               $withdrawDto->setDescription($description);
               $withdrawDto->setPin($senderAccountPin);
               $depositDto->setAccountNumber($lockedreceiverAccount->account_number);
               $depositDto->setAmount($amount);
               $depositDto->setDescription($description);
               $transferDto->setReference($transactionService->generateReference());
               $transferDto->setSenderId($senderaccountRepo->getUserId());
               $transferDto->setSenderAccountId($senderaccountRepo->getId());
               $transferDto->setRecipientId($receiveraccountRepo->getUserId());
               $transferDto->setRecipientAccountId($receiveraccountRepo->getId());
               $transferDto->setAmount($amount);
               //check if the sender can actually perform a withdrawal
               $this->canWithdraw($senderaccountRepo,$withdrawDto);
               $transactionWithdrawalRepo =  $transactionDto->forWithdrawal(
               $senderaccountRepo,
               $withdrawDto,
               $transactionService->generateReference()
               );
               $transactionDepositRepo =  $transactionDto->forDeposit(
               $receiveraccountRepo,
               $depositDto,
               $transactionService->generateReference(),
               );
               $transfer = $transferService->createTransfer($transferDto); 
               $transactionWithdrawalRepo->setTransferId($transfer->id);
               $transactionDepositRepo->setTransferId($transfer->id);
               //dd($transactionDepositRepo->getTransferId());
            //use event to decouple what is happen in an event
            
            // event(new DepositEvent($transactionDepositRepo,$senderaccountRepo,$lockedsenderAccount));
            // event(new WithdrawalEvent($transactionWithdrawalRepo,$receiveraccountRepo,$lockedreceiverAccount));

            event(new DepositEvent($transactionWithdrawalRepo,$senderaccountRepo,$lockedsenderAccount));
            event(new WithdrawalEvent($transactionDepositRepo,$receiveraccountRepo,$lockedreceiverAccount));

            
            
           DB::commit();
         }catch(\Exception $e){
           
            DB::rollback();
            throw $e;
         }
    }

    public function canWithdraw($accountRepo,$withdrawRepository)
    {
        //to check if the account is blocked
        //check if user has not exceed transaction limit of the day
        //amount to withdraw is not greater than the user balance.
        if($accountRepo->getBalance() < $withdrawRepository->getAmount()){
            throw new InsuffientBalanceException();
        }
        //if the balance left after withdraw is  more than the minimium account balance
        return true;
    }

    
}

