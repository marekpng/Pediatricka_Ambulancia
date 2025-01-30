<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
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

Route::middleware(['auth:sanctum'])->group(function () {

});



// overuje sa VNUTRI v METODE ci je uzivatel prihlaseny alebo nie cez IdentifyService

Route::get('/appointments', [AppointmentController::class, 'index']);


Route::get('/appointments/{id}', [AppointmentController::class, 'show']);


Route::put('/appointments/{id}', [AppointmentController::class, 'update']);


Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);


//Tu nie je potreba prihlasenia ale overuje sa RodneCislo a Meno
Route::post('/appointments', [AppointmentController::class, 'store']);





//SCHEDULE Endpointy vytvaranie harmonogramu sluzieb cas na pacientov days off


//PRIVATE iba admin mozem pristupit

    Route::post('/schedule/working-hours', [ScheduleController::class, 'setWorkingHours']);

   
    Route::post('/schedule/days-off', [ScheduleController::class, 'setDaysOff']);

    
    Route::post('/schedule/generate-timeslots', [ScheduleController::class, 'generateTimeslots']);

   
    Route::delete('/schedule/days-off/{id}', [ScheduleController::class, 'deleteDaysOff']);

    Route::get('/schedule/all', [ScheduleController::class, 'getAllSchedules']);
    Route::delete('/schedule/timeslots/{id}', [ScheduleController::class, 'deleteTimeslot']);
    Route::put('/schedule/timeslots/{id}', [ScheduleController::class, 'updateTimeslot']);


//PUBLIC
//Ziskat booknute a nebooknute timesloty

    Route::get('/schedule', [ScheduleController::class, 'index']);
    
    Route::get('/schedule/timeslots/booked', [ScheduleController::class, 'getBookedTimeslots']);

    
    Route::get('/schedule/timeslots/available', [ScheduleController::class, 'getAvailableTimeslots']);


// Appointments CRUD pre admina cez Vue.js frontend
Route::get('/admin/appointments', [AppointmentController::class, 'index']);
Route::put('/admin/appointments/{id}', [AppointmentController::class, 'update']);
Route::delete('/admin/appointments/{id}', [AppointmentController::class, 'destroy']);
