<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\MainInterface;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Enum\TransactionCategoryEnum;


class TransferRepository

{

    private int $account_number;
    private int|float $sender_id;
    private int $sender_account_id;
    private int $recipient_id;
    private int $recipient_account_id;
    private int $amount;
    private ?int $status = null;
    private $reference;
    private Carbon $created_at;
    private Carbon $update_at;


    public function getAccountNumber(){

        return $this->account_number;
    }

    public function setAccountNumber($account_number){

        return $this->account_number = $account_number;
    }

    public function getAmount(){

        return $this->amount;
    }

    public function setAmount($amount){

        return $this->amount = $amount;
    }

    public function getSenderAccountId(){

        return $this->sender_account_id;
    }

    public function setSenderAccountId($sender_account_id){

        return $this->sender_account_id = $sender_account_id;
    }

    public function getSenderId(){

        return $this->sender_id;
    }

    public function setSenderId($sender_id){

        return $this->sender_id = $sender_id;
    }

    public function getRecipientId(){

        return $this->recipient_id;
    }

    public function setRecipientId($recipient_id){

        return $this->recipient_id = $recipient_id;
    }

     public function getRecipientAccountId(){

        return $this->recipient_account_id;
    }

    public function setRecipientAccountId($recipient_account_id){

        return $this->recipient_account_id = $recipient_account_id;
    }

    public function getStatus(){

        return $this->status;
    }

    public function setStatus($status){

        return $this->status = $status;
    }

    public function getReference(){

        return $this->reference;
    }

    public function setReference($reference){

        return $this->reference  = $reference;
    }

    public function getCreatedAt(){

        return $this->created_at;
    }

    public function setCreatedAt($created_at){

        return $this->created_at = $created_at;
    }

    public function getUpdatedAt(){

        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at){

        return $this->updated_at = $updated_at;
    }

    

    public static function fromApiFormRequest(FormRequest $request){
        
         $transferDto = new TransferRepository();
         $transferDto->setAccountNumber($request->account_number);
         $transferDto->setAmount($request->amount);
         $transferDto->setDescription($request->description);
         $transferDto->setCategory(TransactionCategoryEnum::DEPOSIT->value);
         //$transferDto->setStatus('success');
         return $transferDto;
    }

    public function forTransferToArray($transferRepository)
    {

        return [
             'sender_id' => $transferRepository->getSenderId(),
             'sender_account_id' => $transferRepository->getSenderAccountId(),
             'recipient_id' => $transferRepository->getRecipientId(),
             'recipient_account_id' => $transferRepository->getRecipientAccountId(),
             'reference' => $transferRepository->getReference(),
             'status' => 'Success',
             'amount' => $transferRepository->getAmount(),
            //  'date' => Carbon::now(),
            //  'description' => $transactionRepository->description,

        ];
    }

}