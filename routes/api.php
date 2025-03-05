<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Catalogos\catRolesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::get('roles/getAll', [catRolesController::class, 'getAll']);
Route::get('roles/getById/{Id}', [catRolesController::class, 'getById']);
Route::get('roles/getAllHabilitados', [catRolesController::class, 'getAllHabilitados']);
Route::post('roles/create', [catRolesController::class, 'store']);
Route::post('roles/update/{Id}', [catRolesController::class, 'update']);
