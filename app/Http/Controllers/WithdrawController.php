<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WithdrawRequest;
use App\Repositories\WithdrawRepository;
use App\Services\AccountService;
use App\Services\TransactionService;

class WithdrawController extends Controller
{

    public function store(WithdrawRequest $request, AccountService $accountService, WithdrawRepository $withdrawRepository,TransactionService $transactionService)
    {
        $account = $accountService->getAccountByUserId($request->user()->id);
        $withdrawRepo = $withdrawRepository->fromApiFormRequest($request,$account);
        $accountService->withdraw($withdrawRepo,$transactionService);
        return $this->sendSuccess([],'Withdrawal is Successful');
    }
}
