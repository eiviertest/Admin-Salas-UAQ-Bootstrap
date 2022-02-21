<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\CursoPersonaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/curso', [CursoController::class, 'index']);
    Route::post('/curso', [CursoController::class, 'store']);
    Route::put('/curso/{id}', [CursoController::class, 'disable']);
    Route::get('/lista_curso_persona', [CursoPersonaController::class, 'lista_curso_persona']);
    Route::post('/enrolarse', [CursoPersonaController::class, 'enrolarse_curso']);
    Route::put('/rechazar_persona_curso', [CursoPersonaController::class, 'rechazar_persona_curso']);
    Route::put('/aceptar_persona_curso', [CursoPersonaController::class, 'aceptar_persona_curso']);
});
