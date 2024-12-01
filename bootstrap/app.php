<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponseTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Exceptions\PinAlreadyBeenSetException;
use App\Exceptions\InvalidPinLengthException;
use App\Exceptions\SetPinException;
use App\Exceptions\PinNotValidException;
use App\Exceptions\AccountNumberExistException;
use App\Exceptions\AmountTooLowException;
use App\Exceptions\InvalidAccountNumberException;
use App\Http\Middleware\EnforeJsonResponse;
use App\Http\Middleware\HasSetPinMiddleware;
use App\Exceptions\AccountNotFoundException;
use App\Exceptions\AmountTooLowForWithdrawalException;
use App\Exceptions\ANotFountException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
         $middleware->alias([

            'enforcejson'=>EnforeJsonResponse::class,
            'has_set_pin' => HasSetPinMiddleware::class

         ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {

        
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
        if ($request->is('api/*')) {
              $statusCode = Response::HTTP_NOT_FOUND;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode 
            ],$statusCode);

        }
        });

       $exceptions->render(function (UniqueConstraintViolationException $e, Request $request) {
        if ($request->is('api/*')) {
               $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

       $exceptions->render(function (QueryException $e, Request $request) {
        if ($request->is('api/*')) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        

        $exceptions->render(function (ValidationException $e, Request $request) {
        if ($request->is('api/*')) {
              $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
              \Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode,
                'errors' => $e->errors()
            ],$statusCode);

        }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_UNAUTHORIZED;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (PinAlreadyBeenSetException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (InvalidPinLengthException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (SetPinException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (PinNotValidException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (AccountNumberExistException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (AmountTooLowException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        
        $exceptions->render(function (InvalidAccountNumberException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (AccountNotFoundException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (AmountTooLowForWithdrawalException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        $exceptions->render(function (ANotFountException $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_BAD_REQUEST;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        
        $exceptions->render(function (Exception $e, Request $request) {
        if ($request->is('api/*')) {
             $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
              Log::error($e);
              return ApiResponseTrait::apiResponse([
                'message' => $e->getMessage(),
                'success'=>false,
                'exception' => $e,
                'error_code' => $statusCode
            ],$statusCode);

        }
        });

        

           
    })->create();
