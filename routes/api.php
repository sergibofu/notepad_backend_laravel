<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotesController;

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

//rutas de usuario
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //ruta para el logout
    Route::post('logout', [AuthController::class, 'logout']);

    //las rutas de nuestra api notas
    Route::prefix('notes')->group(function () {
        Route::get('/', [NotesController::class, 'notes']);
        Route::post('create', [NotesController::class, 'createNote']);
        Route::put('update', [NotesController::class, 'updateNote']);
        Route::delete('delete', [NotesController::class, 'deleteNote']);
    });

});
