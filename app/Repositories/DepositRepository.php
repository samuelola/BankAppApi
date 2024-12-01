<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\MainInterface;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Enum\TransactionCategoryEnum;


class DepositRepository

{

    private int $account_number;
    private int|float $amount;
    private string|null $description;
    private ?string $category = null;


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

    public function getDescription(){

        return $this->description;
    }

    public function setDescription($description){

        return $this->description = $description;
    }

    // public function getCategory(){

    //     return TransactionCategoryEnum::DEPOSIT->value;
    // }

    public function getCategory(){

        return $this->category;
    }

    public function setCategory($category){

        return $this->category = $category;
    }

    

    public static function fromApiFormRequest(FormRequest $request){
        
         $depositeDto = new DepositRepository();
         $depositeDto->setAccountNumber($request->account_number);
         $depositeDto->setAmount($request->amount);
         $depositeDto->setDescription($request->description);
         $depositeDto->setCategory(TransactionCategoryEnum::DEPOSIT->value);
         return $depositeDto;
    }

}