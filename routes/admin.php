<?php

use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\SystemLog\SystemLogController;
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

Route::group(['middleware' => ['auth:sanctum', 'is-admin']], function () {
    Route::get('log', [SystemLogController::class, 'index']);
    Route::get('setting', [SettingController::class, 'index']);
    Route::post('setting', [SettingController::class, 'store']);
});
