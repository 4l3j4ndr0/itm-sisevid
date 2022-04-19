<?php

use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\CapituloController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\CondicionController;
use App\Http\Controllers\FacultadController;
use App\Http\Controllers\ProgramaAcademicoController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LogMiddleware;
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

Route::middleware([LogMiddleware::class])->group(function () {

    Route::prefix('user')->group(function () {
        Route::post('/create', [UserController::class, 'create']);
        Route::put('/update', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);
        Route::get('/get/{id}', [UserController::class, 'getUser']);
        Route::get('/list', [UserController::class, 'list']);
        Route::get('/tipoPersonas', [UserController::class, 'getTiposUsuario']);
    });

    Route::prefix('facultad')->group(function () {
        Route::post('/create', [FacultadController::class, 'create']);
        Route::put('/update', [FacultadController::class, 'update']);
        Route::delete('/delete/{id}', [FacultadController::class, 'delete']);
        Route::get('/decanos', [FacultadController::class, 'getDecanos']);
        Route::get('/get/{id}', [FacultadController::class, 'getFacultad']);
        Route::get('/list', [FacultadController::class, 'list']);
    });

    Route::prefix('ciclo')->group(function () {
        Route::post('/create', [CicloController::class, 'create']);
        Route::put('/update', [CicloController::class, 'update']);
        Route::delete('/delete/{id}', [CicloController::class, 'delete']);
        Route::get('/get/{id}', [CicloController::class, 'getCiclo']);
        Route::get('/list', [CicloController::class, 'list']);
    });

    Route::prefix('programa')->group(function () {
        Route::post('/create', [ProgramaAcademicoController::class, 'create']);
        Route::put('/update', [ProgramaAcademicoController::class, 'update']);
        Route::delete('/delete/{id}', [ProgramaAcademicoController::class, 'delete']);
        Route::get('/get/{id}', [ProgramaAcademicoController::class, 'getPrograma']);
        Route::get('/list', [ProgramaAcademicoController::class, 'list']);
    });

    Route::prefix('condicion')->group(function () {
        Route::post('/create', [CondicionController::class, 'create']);
        Route::put('/update', [CondicionController::class, 'update']);
        Route::delete('/delete/{id}', [CondicionController::class, 'delete']);
        Route::get('/get/{id}', [CondicionController::class, 'getCondicion']);
        Route::get('/list', [CondicionController::class, 'list']);
    });

    Route::prefix('capitulo')->group(function () {
        Route::post('/create', [CapituloController::class, 'create']);
        Route::put('/update', [CapituloController::class, 'update']);
        Route::delete('/delete/{id}', [CapituloController::class, 'delete']);
        Route::get('/get/{id}', [CapituloController::class, 'getCapitulo']);
        Route::get('/list', [CapituloController::class, 'list']);
    });

    Route::prefix('asignatura')->group(function () {
        Route::post('/create', [AsignaturaController::class, 'create']);
        Route::put('/update', [AsignaturaController::class, 'update']);
        Route::delete('/delete/{id}', [AsignaturaController::class, 'delete']);
        Route::get('/get/{id}', [AsignaturaController::class, 'getAsignatura']);
        Route::get('/list', [AsignaturaController::class, 'list']);
    });
});
