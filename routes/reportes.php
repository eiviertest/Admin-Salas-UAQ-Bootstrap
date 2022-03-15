<?php

use App\Http\Controllers\CursoPersonaController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/cursos_impartidos', [CursoPersonaController::class, 'cursos_impartidos']);
    Route::get('/cursos_impartidos_pdf/{id}', [CursoPersonaController::class, 'cursos_impartidos_pdf']);
    Route::get('/concentrado_curso/{id}', [CursoPersonaController::class, 'concentrado_curso']);
    Route::get('/concentrado_curso_pdf/{id}', [CursoPersonaController::class, 'concentrado_curso_pdf']);
    Route::get('/area_solicitudes_detalle/{id}', [SolicitudController::class, 'area_solicitudes_detalle']);
    Route::get('/area_solicitudes_detalle_pdf/{id}', [SolicitudController::class, 'area_solicitudes_detalle_pdf']);
});
