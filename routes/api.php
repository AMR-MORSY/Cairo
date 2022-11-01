<?php

use Maatwebsite\Excel\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NUR\NUR2GController;
use App\Http\Controllers\NUR\NUR3GController;
use App\Http\Controllers\NUR\NUR4GController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\NUR\ShowNURController;
use App\Http\Controllers\Sites\SitesController;
use App\Http\Controllers\User\LogoutController;
use App\Http\Controllers\NUR\NurIndexController;
use App\Http\Controllers\Sites\NodalsController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\Sites\CascadesController;
use App\Http\Controllers\EnergySheet\EnergyController;

use App\Http\Controllers\User\ResetPasswordController;
use App\Http\Controllers\Modifications\ModificationsController;

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

Route::middleware('auth:sanctum')->prefix("user")->group(function(){
    Route::post('/logout',[LogoutController::class,"logout"]);
    Route::get("refreshsession",[LoginController::class,"refresh_session"]);

});


Route::prefix("energysheet")->middleware(['auth:sanctum',"role:admin|super-admin"])->group(function(){
    Route::get('/index',[EnergyController::class,"index"] )->name("energysheet_index");
    Route::post('/index',[EnergyController::class,"store_alarms"] )->name("energysheet_store_alarms");

});

Route::prefix('modifications')->middleware(['auth:sanctum',"role:admin|super-admin"])->group(function(){
    Route::get("/analysis",[ModificationsController::class,"analysis"])->name("analysis");
    Route::post("/index",[ModificationsController::class,"index"])->name("index");
});


Route::prefix('sites')->middleware(['auth:sanctum',"role:super-admin"])->group(function(){
    // Route::get('/newsitesinsert',[SitesController::class,"index"])->name("sites");
    Route::post('/store',[SitesController::class,"store"])->name("store_sites");
    Route::get('/downloadAll',[SitesController::class,"export_all"])->name("export_all");
    Route::get('/cascades',[CascadesController::class,"exportAllCascades"])->name("all_cascades");
    Route::post('/cascades',[CascadesController::class,"importCascades"])->name("import_cascades");
    Route::post('/nodals',[NodalsController::class,"importNodals"])->name("import_nodals");

});
Route::prefix('Nur')->middleware(['auth:sanctum',"role:super-admin"])->group(function(){
    // Route::get('/newsitesinsert',[SitesController::class,"index"])->name("sites");
    Route::get('/index',[NurIndexController::class,"index"])->name("Nur_index");
    Route::post('/2G',[NUR2GController::class,"store"])->name("store_2G");
    Route::post('/3G',[NUR3GController::class,"store"])->name("store_3G");
    Route::post('/4G',[NUR4GController::class,"store"])->name("store_4G");
  
   

});
Route::prefix('Nur')->middleware(['auth:sanctum',"role:admin|super-admin"])->group(function(){
    Route::post('/siteNUR',[ShowNURController::class,"SiteNUR"])->name("siteNUR");
    Route::post('/show',[ShowNURController::class,"show_nur"])->name("show_nur");
});

Route::prefix("user")->group(function(){
Route::post("/register",[RegisterController::class,"register"]);
Route::post("/login",[LoginController::class,"login"]);
Route::post("/sendToken",[ResetPasswordController::class,"sendToken"]);
Route::post("/validateToken",[ResetPasswordController::class,"validateToken"]);
Route::post("/resetPassword",[ResetPasswordController::class,"resetPassword"]);
});
