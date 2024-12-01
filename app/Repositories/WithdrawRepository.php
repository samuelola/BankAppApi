<?php


namespace App\Repositories;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Enum\TransactionCategoryEnum;

class WithdrawRepository{

    // private int $account_number;
    private int|float $amount;
    private string|null $description;
    private ?string $category = null;
    private string $pin;


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

    public function getPin(){

        return $this->pin;
    }

    public function setPin($pin){

        return $this->pin = $pin;
    }

    public function getCategory(){

        return $this->category;
    }

    public function setCategory($category){

        return $this->category = $category;
    }

    public static function fromApiFormRequest(FormRequest $request,$account){
        
         $withdrawDto = new WithdrawRepository();
         $withdrawDto->setAmount($request->amount);
         $withdrawDto->setDescription($request->description);
         $withdrawDto->setPin($request->pin);
         $withdrawDto->setAccountNumber($account->account_number);
         $withdrawDto->setCategory(TransactionCategoryEnum::WITHDRAWAL->value);
         return $withdrawDto;
    }
}