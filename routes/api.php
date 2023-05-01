<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TransectionController;
use App\Http\Controllers\API\BillsController;
use App\Http\Controllers\API\ReportController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("register", [UserController::class,"register"]);
Route::post("login", [UserController::class,"login"]);
Route::post("logout", [UserController::class,"logout"]);

// ເສັ້ນທາງພິມບິນ
Route::get("bill/{id}", [BillsController::class,"print"]);

Route::group(['prefix'=>'store','middleware'=>'auth:sanctum'], function(){
    Route::post("add", [StoreController::class,"add"]);
    Route::get("/", [StoreController::class,"index"]);
    Route::get("edit/{id}", [StoreController::class,"edit"]);
    Route::post("update/{id}", [StoreController::class,"update"]);
    Route::delete("delete/{id}", [StoreController::class,"detele"]);
});

Route::group(['prefix'=>'transection','middleware'=>'auth:sanctum'], function(){
    Route::post("add", [TransectionController::class,"add"]);
    Route::post("/", [TransectionController::class,"index"]);
    // Route::get("edit/{id}", [TransectionController::class,"edit"]);
    // Route::post("update/{id}", [TransectionController::class,"update"]);
    // Route::delete("delete/{id}", [TransectionController::class,"detele"]); 
});

Route::group(['prefix'=>'report','middleware'=>'auth:sanctum'], function(){
    Route::post("/", [ReportController::class,"created_report"]);
    Route::get("/grapdashboard", [ReportController::class,"GetDataDashboard"]);
});



