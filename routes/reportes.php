<?php

use App\Http\Controllers\CursoPersonaController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

//Route::group(['middleware' => ['auth']], function () {
    Route::get('/cursos_impartidos', [CursoPersonaController::class, 'cursos_impartidos']);
    Route::get('/concentrado_curso', [CursoPersonaController::class, 'concentrado_curso']);
    Route::get('/solicitud_persona', [SolicitudController::class, 'solicitud_persona']);
// });
