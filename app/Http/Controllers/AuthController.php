<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Auth;


class AuthController extends Controller
{
    public function register(RegisterUserRequest $request, UserService $userService) : JsonResponse
    {
        // User::create([]);
        //User::query()->findOrFail(3000);
        $userData = UserRepository::fromApiFormRequest($request);
        $user = $userService->createUser($userData);
        return $this->sendSuccess(['result'=>$user],'Registration Successful');
    }

    public function login(LoginRequest $request)
    {
       $credentials = $request->validated();
       if(!Auth::attempt($credentials)){
         return $this->sendError('Provided Credentials are Incorrect');
       }
       $user = $request->user();
       $token = $user->createToken('auth_token')->plainTextToken;
       return $this->sendSuccess(['result' => $user,'token'=>$token],'Login is Successful');
    }

    public function user(Request $request)
    {
        return $this->sendSuccess([
            'result' => $request->user()
        ],'Authenticated User retrieved Successfully');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return $this->sendSuccess([
            
          ],'User logged out Successfully');
    }


}
