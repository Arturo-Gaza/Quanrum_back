<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Catalogos\CatCategoriaController;
use App\Http\Controllers\Catalogos\catRolesController;
use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

//APIS de roles
Route::get('roles/getAll', [catRolesController::class, 'getAll']);
Route::get('roles/getById/{Id}', [catRolesController::class, 'getById']);
Route::get('roles/getAllHabilitados', [catRolesController::class, 'getAllHabilitados']);
Route::post('roles/create', [catRolesController::class, 'store']);
Route::post('roles/update/{Id}', [catRolesController::class, 'update']);

//APIS de usuarios
Route::get('usuarios/getAll', [UsuarioController::class, 'getAll']);


//APIS de categoria
Route::get('categoria/getAll', [CatCategoriaController::class, 'getAll']);
Route::post('categoria/create', [CatCategoriaController::class, 'store']);


