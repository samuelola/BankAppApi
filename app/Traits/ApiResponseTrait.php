<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;


trait ApiResponseTrait{

    public static function parseResponse(array $data=[], int $statusCode =200, array $headers=[]){

        $responseStructure = [
             'success' => $data['success'] ?? false,
             'message' => $data['message'] ?? null,
             'result'  => $data['result']  ?? null,
        ];

        if(isset($data['errors'])){
            $responseStructure['errors'] = $data['errors'];
        }
        if(isset($data['status'])){
            $statusCode = $data['status'];
        }

        if(isset($data['exception']) && ($data['exception'] instanceof \Error || $data['exception'] instanceof \Exception)){
            if(config('app.env') !== 'production'){
                 $responseStructure['exception'] = [
                     'message' => $data['exception']->getMessage(),
                     'file' => $data['exception']->getFile(),
                     'line' => $data['exception']->getLine(),
                     'code' => $data['exception']->getCode(),
                     'trace'=> $data['exception']->getTrace()
                 ];
            }
            if($statusCode == 200){
               $statusCode = 500;
            }
        }

        if(isset($data['status']) == false){
           if(isset($data['error_code'])){
              $responseStructure['error_code'] = $data['error_code'];
           }else{
              $statusCode;
           }
        }

        return ['content' => $responseStructure, 'statusCode'=> $statusCode, 'headers'=> $headers];
        
    }

    public static function apiResponse(array $data=[], int $statusCode =200, array $headers=[]){
        $result = self::parseResponse($data,$statusCode,$headers);
        return response()->json($result['content'],$result['statusCode'],$result['headers']);
    }

    public function sendSuccess(mixed $data=[], string $message=''){
       return self::apiResponse(
        [
            'result'=>$data,
            'success'=>true,
            'message'=>$message
        ]);
    }
    
    

    public function sendError(string $message='', int $statusCode=500, int $error_code = 1){
       return self::apiResponse(
        [
            'success'=>false,
            'message'=>$message,
            'error_code'=>$error_code,
            
        ], $statusCode);
    }
    
    public function sendUathorized(string $message='Unathorized Access'){
       return $this->sendError($message);
    }
    
    public function sendFobidden(string $message='Forbidden'){
       return $this->sendError($message);
    }

    public function sendInternalServerError(string $message='Internal Server Error'){
       return $this->sendError($message);
    }

    public function sendValidationError(ValidationException $exception){
       return self::apiResponse(
        [
            'success'=>false,
            'message'=>$exception->getMessage(),
            'errors'=>$exception->errors(),
        ]);
    }
}