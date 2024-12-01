<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DepositRequest;
use App\Services\AccountService;
use App\Repositories\DepositRepository;
use App\Services\TransactionService;


class DepositController extends Controller
{

    public function store(DepositRequest $request, AccountService $accountService, DepositRepository $depositRepository,TransactionService $transactionService)
    {
        $depositRepo = $depositRepository->fromApiFormRequest($request);
        $accountService->deposit($depositRepo,$transactionService);
        return $this->sendSuccess([],'Deposit is Successful');
    }
}
