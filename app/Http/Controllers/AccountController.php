<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AccountService;
use App\Repositories\UserRepository;

class AccountController extends Controller
{

    public function store(Request $request, AccountService $accountService)
    {
        $userrepo = new UserRepository();
        $result = $userrepo::fromModel($request->user());
        $account = $accountService->createAccountNumber($result);
        return $this->sendSuccess(['account'=> $account],'Account Number generated successfully');
    }
}
