<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class PinController extends Controller
{
    public function setPin(Request $request, UserService $userService)
    {
       $request->validate([

          'pin' => 'required|string|min:4|max:4'
       ]
    
       );

       
       /** @var User $user */
       //get the validated user
       $user = $request->user();
       $userService->setUpPin($user,$request->pin);
       return $this->sendSuccess([],'Pin is set Successfully');
    }

    public function validatepin(Request $request, UserService $userService)
    {
        $request->validate([

          'pin' => 'required|string'
       ]
    
       );

       
       /** @var User $user */
       //get the validated user
       $userId = $request->user()->id;
       $isValid = $userService->validatePin($userId,$request->pin);
       return $this->sendSuccess(['is_valid'=>$isValid],'Pin is valid');
    }
}
