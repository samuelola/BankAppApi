<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransferRequest;
use App\Services\AccountService;
use App\Repositories\DepositRepository;
use App\Services\TransactionService;


class TransferController extends Controller
{
    public function store(TransferRequest $request,AccountService $accountService)
    {

         $user = $request->user();
         $sender_account = $accountService->getAccountByUserId($user->id);
         $transferDto = $accountService->transfer(
            $sender_account->account_number,
            $request->pin,
            $request->receiver_account_number,
            $request->amount,
            $request->description
         );

         
         
         return $this->sendSuccess(['transfer'=>$transferDto],'Transfer in progress');
    }
    
}
