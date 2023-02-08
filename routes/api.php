<?php

use App\Http\Controllers\Api\AssistanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonalController;

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
Route::get('personal/{personal_id}/get-assistance', [AssistanceController::class, 'getStaffDayAttendance'])->name('personal.get-assistance');
Route::post('personal/{personal_id}/mark-start-time', [AssistanceController::class, 'markStartTime'])->name('personal.mark-start-time');
Route::put('personal/{personal_id}/mark-time-of', [AssistanceController::class, 'markTimeOf'])->name('personal.mark-time-of');

Route::apiResource('personal', PersonalController::class);