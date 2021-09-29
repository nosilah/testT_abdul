<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('registration', [\App\Http\Controllers\Auth\RegistrationController::class, 'registration']);

Route::get('/fucm', [\App\Http\Controllers\HomeController::class, 'index'])->name('unsubscribe');


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('auth/email-authenticate/{token}', [
    \App\Http\Controllers\Auth\AuthController::class, 'authenticateEmail'
])->name('auth.email-authenticate');