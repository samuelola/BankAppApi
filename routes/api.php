<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\TransferController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::middleware(EnforeJsonResponse::class)->prefix('auth')->group(function (){
//     Route::post('register',[AuthController::class,'register']);
//     Route::post('login',[AuthController::class,'login'])->name('login');
//     Route::middleware('auth:sanctum')->group(function(){
//          Route::get('/user',[AuthController::class,'user']);
//          Route::post('logout',[AuthController::class,'logout'])->name('logout');
//     });
// });

Route::middleware('enforcejson')->group(function (){
    Route::prefix('auth')->group(function(){
        Route::post('register',[AuthController::class,'register']);
        Route::post('login',[AuthController::class,'login'])->name('login');
        Route::middleware('auth:sanctum')->group(function(){
            Route::get('/user',[AuthController::class,'user']);
            Route::post('logout',[AuthController::class,'logout'])->name('logout');
        });
    });
    Route::middleware('auth:sanctum')->group(function(){
        Route::prefix('onboarding')->group(function(){
            Route::post('/setpin',[PinController::class,'setPin']); 
            Route::middleware('has_set_pin')->group(function(){
                  Route::post('/validatepin',[PinController::class,'validatepin']); 
                  Route::post('/generateAccount',[AccountController::class,'store']); 
            });
            
        });

         Route::prefix('account')->group(function(){
            Route::post('/deposit',[DepositController::class,'store'])->middleware('has_set_pin');  
            Route::post('/withdraw',[WithdrawController::class,'store'])->middleware('has_set_pin');
            Route::post('/transfer',[TransferController::class,'store'])->middleware('has_set_pin');
        });
        
    });
});




