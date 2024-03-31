<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Password_ManagerController;
use App\Http\Controllers\Zarinpal_Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register' , [AuthenticationController::class , 'register']);
Route::post('/login' , [AuthenticationController::class , 'login']);
Route::post('/logout/{id}' , [AuthenticationController::class , 'logout']);
Route::post('/sms_register_check/{id}' , [AuthenticationController::class , 'sms_register_check']);
//-------password-------//
Route::post('/send' , [Password_ManagerController::class , 'send_sms']);
Route::post('/resend_sms' , [Password_ManagerController::class , 'repeat_code']);
Route::post('/check/{id}' , [Password_ManagerController::class , 'check_sms']);
Route::post('/change_pass/{id}' , [Password_ManagerController::class , 'reset_password']);
Route::post('/payment' , [Zarinpal_Controller::class , 'payment']);

