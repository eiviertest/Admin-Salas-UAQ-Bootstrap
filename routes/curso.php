<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\CursoPersonaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/curso', [CursoController::class, 'index']);
    Route::get('/curso_admin', [CursoController::class, 'index_admin']);
    Route::get('/getDataCurso/{idCurso}', [CursoController::class, 'getDataCurso']);
    Route::post('/curso', [CursoController::class, 'store']);
    Route::put('/update_curso', [CursoController::class, 'update']);
    Route::put('/curso', [CursoController::class, 'disable']);
    Route::get('/catalogo_curso', [CursoController::class, 'catalogoCurso']);
    Route::get('/lista_curso_persona', [CursoPersonaController::class, 'lista_curso_persona']);
    Route::get('/mis_cursos_persona', [CursoPersonaController::class, 'mis_cursos_persona']);
    Route::post('/enrolarse', [CursoPersonaController::class, 'enrolarse_curso']);
    Route::put('/rechazar_persona_curso', [CursoPersonaController::class, 'rechazar_persona_curso']);
    Route::put('/aceptar_persona_curso', [CursoPersonaController::class, 'aceptar_persona_curso']);
});
