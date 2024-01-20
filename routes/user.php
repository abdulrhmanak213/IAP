<?php

use App\Http\Controllers\File\UserFileController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\File\FileController;
use App\Http\Controllers\User\Folder\FolderController;
use App\Http\Controllers\User\Log\LogController;
use App\Http\Controllers\User\UserController;
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
Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('file/status-toggle', [FileController::class, 'statusToggle']);
    Route::post('file/lock', [FileController::class, 'lock']);
    Route::post('file/release', [FileController::class, 'unLock']);
    Route::get('file/owner', [FileController::class, 'ownerFiles']);
    Route::post('file/{id}', [FileController::class, 'update']);
    Route::apiResource('file', FileController::class)->middleware('check-file-count');

    Route::get('file/{id}/users', [UserFileController::class, 'index']);
    Route::post('/{user}/file/{file}', [UserFileController::class, 'store']);
    Route::delete('/{user}/file/{file}', [UserFileController::class, 'destroy']);


    Route::get('file/log/{file}', [LogController::class, 'index']);
    Route::post('folder', [FolderController::class, 'store']);
    Route::delete('folder/{id}', [FolderController::class, 'destroy']);
});
