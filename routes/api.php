<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\Sites\SitesController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\EnergySheet\EnergyController;
use App\Http\Controllers\User\ResetPasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("energysheet")->group(function(){
    Route::get('/index',[EnergyController::class,"index"] )->name("energysheet_index");
    Route::post('/index',[EnergyController::class,"store_alarms"] )->name("energysheet_store_alarms");

});

// Route::prefix("energysheet")->group(function () {
//      Route::get('/index',[EnergyController::class,"index"] )->name("energysheet_index");
//     Route::post('/index',[EnergyController::class,"store_alarms"] )->name("energysheet_store_alarms");
// });
Route::prefix('sites')->group(function(){
    // Route::get('/newsitesinsert',[SitesController::class,"index"])->name("sites");
    Route::post('/store',[SitesController::class,"store"])->name("store_sites");

});

Route::prefix("user")->group(function(){
Route::post("/register",[RegisterController::class,"register"]);
Route::post("/login",[LoginController::class,"login"]);
Route::post("/sendToken",[ResetPasswordController::class,"sendToken"]);
Route::post("/validateToken",[ResetPasswordController::class,"validateToken"]);
Route::post("/resetPassword",[ResetPasswordController::class,"resetPassword"]);
});
