<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use App\Interfaces\UserServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\PinAlreadyBeenSetException;
use App\Exceptions\InvalidPinLengthException;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\SetPinException;
use App\Exceptions\PinNotValidException;

class UserService implements UserServiceInterface

{

    public function createUser(UserRepository $UserRepository){
        
        return User::query()->create([
            'name' => $UserRepository->getName(),
            'email' => $UserRepository->getEmail(),
            'password' => $UserRepository->getPassword(),
            'phone_number' => $UserRepository->getPhoneNumber()
         ]);
    }

    public function getUserById(int $userId)
    {
        $user = User::query()->where('id',$userId)->first();
        if(!$user){
            throw new NotFoundHttpException("user not found");
        }
        return $user;
    }

    public function setUpPin(User $user, string $pin): void
    {
         if($this->hasSetPin($user)){
            throw new PinAlreadyBeenSetException("Pin has already been set");
         }
        if(strlen($pin) != 4){
            throw new InvalidPinLengthException("Length of pin must be equal to 4");
        }
        $user->pin = Hash::make($pin);
        $user->save();
    }
    public function validatePin($userId, $pin): bool
    {
         $user = $this->getUserById($userId);
         if(!$this->hasSetPin($user)){
            throw new SetPinException("Set your Pin");
         }
         $check = Hash::check($pin,$user->pin);
         if($check == false){
            throw new PinNotValidException('Pin not Valid');
         }
         return Hash::check($pin,$user->pin);
    }
    public function hasSetPin(User $user): bool
    {
        return $user->pin != null;
    }

    
}