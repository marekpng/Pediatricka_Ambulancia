<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\DoctorController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index']);
    Route::post('/', [DoctorController::class, 'store']);
    Route::get('/{doctor}', [DoctorController::class, 'show']);
    Route::post('/{doctor}', [DoctorController::class, 'update']);
    Route::delete('/{doctor}', [DoctorController::class, 'destroy']);
});


Route::get('/blog-posts', [BlogPostController::class, 'index']);
Route::get('/blog-posts/{slug}', [BlogPostController::class, 'show']);
Route::post('/blog-posts', [BlogPostController::class, 'store']);
//Route::put('/blog-posts/{id}', [BlogPostController::class, 'update']);
Route::post('/blog-posts/{id}', [BlogPostController::class, 'update']);

Route::delete('/blog-posts/{id}', [BlogPostController::class, 'destroy']);
