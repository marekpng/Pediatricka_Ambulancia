<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
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
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);


//PROTECTED ROUTES
Route::group(['middleware' => ['auth:sanctum']], function () {
//LOGOUT
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);



});
Route::get('/doctors', [\App\Http\Controllers\DoctorController::class, 'index']);
//Route::prefix('doctors')->group(function () {
////    Route::get('/', [\App\Http\Controllers\DoctorController::class, 'index']);
//    Route::post('/', [\App\Http\Controllers\DoctorController::class, 'store']);
//    Route::get('/{doctors}', [\App\Http\Controllers\DoctorController::class, 'show']);
//    Route::put('/{doctors}', [\App\Http\Controllers\DoctorController::class, 'update']);
//    Route::delete('/{doctors}', [\App\Http\Controllers\DoctorController::class, 'destroy']);
//});

//Pre overenie ci je uzivatel autentifikovany pomocou tokenu
Route::middleware('auth:sanctum')->get('/user', [\App\Http\Controllers\UserController::class, 'showAuthenticatedUser']);


// In IdentityService's routes/api.php
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();  // Returns the authenticated user's details
//});
