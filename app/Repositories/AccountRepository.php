<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\MainInterface;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class AccountRepository
 {

    private int $id;
    private int $user_id;
    private string|null $account_number;
    private float $balance;
    private Carbon $created_at;
    private Carbon $updated_at;


    public function getId(){
       
       return $this->id;
    }
    public function setId($id){
       
        return $this->id = $id;
    }

    public function getUserId(){
       
        return $this->user_id;
    }

    public function setUserid($user_id){
       
       return $this->user_id = $user_id;
    }


    public function getAccountNumber(){
       
        return $this->account_number;
    }

    public function setAccountNumber($account_number){
       
        return $this->account_number = $account_number;
    }

    public function getBalance(){
       
        return $this->balance;
    }

    public function setBalance($balance){
       
        return $this->balance = $balance;
    }

    // gives info about authenticated user
    public static function fromModel($lockedAccount){
         $accountDto = new AccountRepository();
         $accountDto->setId($lockedAccount->id);
         $accountDto->setUserId($lockedAccount->user_id);
         $accountDto->setAccountNumber($lockedAccount->account_number);
         $accountDto->setBalance($lockedAccount->balance);
         return $accountDto;
    }
   
}