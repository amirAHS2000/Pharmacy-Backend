<?php

namespace App\Http\Controllers;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    //All secure URL's

    Route::get("users", [UserController::class, 'index']);

    Route::resource('meds', MedController::class);

    Route::resource('pharms', PharmController::class);

    Route::resource('comps', CompController::class);

    Route::resource('ins', InsController::class);

    Route::resource('patients', PatientController::class);

});

Route::post("login", [UserController::class, 'login']);

Route::post("register", [UserController::class, 'register']);

