<?php

use App\Http\Controllers\ZohoAuthController;
use App\Http\Controllers\ZohoController;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\TokenVerificationMiddleware;


Route::get('/callback', [ZohoAuthController::class, 'handleCallback']);
Route::get('/zoho/auth', [ZohoAuthController::class, 'zohoAuth'])->name('zoho.auth');
Route::middleware(TokenVerificationMiddleware::class)->group(function () {
    Route::get('/', [ZohoController::class, 'index'])->name('welcome');
    Route::get('/getUserZoho', [ZohoAuthController::class, 'getUserZohoDN'])->name('getUserZoho');
    Route::prefix('api')->group(function () {
        Route::get('/getDeals', [ZohoController::class, 'getDeals']);
        Route::get('/getAccounts', [ZohoController::class, 'getAccounts']);
        Route::post('/createDeal', [ZohoController::class, 'createDeal'])->name('createDeal');
        Route::post('/createAccount', [ZohoController::class, 'createAccount'])->name('createAccount');
    });
});


