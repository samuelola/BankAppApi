<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\MainInterface;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UserRepository implements MainInterface {

    private int $id;
    private string $name;
    private string $email;
    private string $phone_number;
    private string $password;
    private string $pin;
    private $created_at;
    private $updated_at;



    public function getId(){

        return $this->id;
    }

    public function setId($id){

        return $this->id = $id;
    }

    public function getName(){

        return $this->name;
    }

    public function setName($name){

        return $this->name = $name;
    }

    public function getEmail(){

        return $this->email;
    }

    public function setEmail($email){

        return $this->email = $email;
    }

    public function getPhoneNumber(){

        return $this->phone_number;
    }

    public function setPhoneNumber($phone_number){

        return $this->phone_number = $phone_number;
    }
    public function getPassword(){

        return $this->password;
    }

    public function setPassword($password){

        return $this->password = $password;
    }
    public function getPin(){

        return $this->pin;
    }

    public function setPin($pin){

        return $this->pin = $pin;
    }
    public function getCreatedAt(){

        return $this->created_at;
    }

    public function setCreatedAt($created_at){

        return $this->created_at = $created_at;
    }

    public function getUpdatedAt(){

        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at){

        return $this->updated_at = $updated_at;
    }

    public static function fromApiFormRequest(FormRequest $request){
        
         $userDto = new UserRepository();
         $userDto->setName($request->name);
         $userDto->setEmail($request->email);
         $userDto->setPhoneNumber($request->phone_number);
         $userDto->setPassword($request->password);
         return $userDto;
    }

    // gives info about authenticated user
    public static function fromModel(Model $model){
         $userDto = new UserRepository();
         $userDto->setId($model->id);
         $userDto->setName($model->name);
         $userDto->setEmail($model->email);
         $userDto->setPhoneNumber($model->phone_number);
         $userDto->setCreatedAt($model->created_at);
         $userDto->setUpdatedAt($model->updated_at);
         return $userDto;
    }
    public static function toArray(Model $model){
       return [
           'id' => $model->id,
           'name' => $model->name,
           'email' => $model->email,
           'phone_number' => $model->phone_number,
           'created_at' => $model->created_at,
           'updated_at' => $model->updated_at,
       ];
    }
}