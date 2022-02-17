<?php

use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/solicitud', [SolicitudController::class, 'index']);
    Route::get('/solicitud_admin', [SolicitudController::class, 'index_admin']);
    Route::post('/solicitud', [SolicitudController::class, 'store']);
    Route::put('/solicitud/{id}', [SolicitudController::class, 'update']);
});
