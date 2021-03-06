<?php

use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/solicitud', [SolicitudController::class, 'index']);
    Route::get('/calendar', [SolicitudController::class, 'calendar']);
    Route::get('/solicitud_admin', [SolicitudController::class, 'index_admin']);
    Route::post('/solicitud', [SolicitudController::class, 'store']);
    Route::put('/solicitud', [SolicitudController::class, 'update']);
    Route::get('/solicitud_mostrar_formato/{uuid}', [SolicitudController::class, 'mostrar_formato']);
    Route::get('/getDataSolicitud/{idSolicitud}', [SolicitudController::class, 'getDataSolicitud']);
});
