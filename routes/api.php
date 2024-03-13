<?php

use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\MasterDataController;
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

Route::get('get-users',[MasterDataController::class,'getAllActiveUsers']);
Route::get('get-jobs',[MasterDataController::class,'getAllActiveJobs']);

Route::post('job-vacancy/list',[JobVacancyController::class,'list']);
Route::post('job-vacancy/store',[JobVacancyController::class,'store']);
Route::delete('job-vacancy/delete/{id}',[JobVacancyController::class,'destroy']);
Route::get('job-vacancy/notification/{id}',[JobVacancyController::class,'sendJobNotification']);