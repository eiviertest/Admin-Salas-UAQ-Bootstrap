<?php

use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/curso', [CursoController::class, 'index']);
    Route::post('/curso', [CursoController::class, 'store']);
    Route::put('/curso/{id}', [CursoController::class, 'disable']);
});
