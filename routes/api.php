<?php

use App\Http\Controllers\Api\AbsenceController;
use App\Http\Controllers\Api\AssistanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\UserController;

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


Route::middleware('auth:sanctum')->group( function () {
    Route::get('personal/{personal_id}/get-assistance', [AssistanceController::class, 'getStaffDayAttendance'])->name('personal.get-assistance');
    Route::post('personal/{personal_id}/mark-start-time', [AssistanceController::class, 'markStartTime'])->name('personal.mark-start-time');
    Route::put('personal/{personal_id}/mark-time-of', [AssistanceController::class, 'markTimeOf'])->name('personal.mark-time-of');
    
    Route::get('personal/{personal_id}/get-absences', [AbsenceController::class, 'getAbsenceByPersonalId'])->name('personal.get-absences');
    Route::get('personal/{personal_id}/verify-absences', [AbsenceController::class, 'verifyAbsenceByPersonalId'])->name('personal.verify-absences');
    Route::post('personal/{personal_id}/store-absences', [AbsenceController::class, 'store'])->name('personal.store-absences');
    Route::put('personal/{personal_id}/update-absences', [AbsenceController::class, 'update'])->name('personal.update-absences');
    Route::delete('personal/{personal_id}/destroy-absences', [AbsenceController::class, 'destroy'])->name('personal.destroy-absences');
    
    Route::apiResource('personal', PersonalController::class);

    Route::get('user', UserController::class)->name('user');

});



Route::get('create_personal_fake', function(){
    App\Models\Personal::factory(10)->create();

    \App\Models\User::factory()->create([
        'name' => fake()->name(),
        'email' => 'grebo@grebo.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => 'jewgjfknewgflne.fj',
    ]);

});