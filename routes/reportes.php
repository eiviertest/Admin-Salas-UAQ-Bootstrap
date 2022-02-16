<?php

use App\Http\Controllers\CursoPersonaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/cursos_impartidos', [CursoPersonaController::class, 'cursos_impartidos']);
    Route::get('/concentrado_curso', [CursoPersonaController::class, 'concentrado_curso']);
});
