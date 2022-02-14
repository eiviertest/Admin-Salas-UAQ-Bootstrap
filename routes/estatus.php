<?php

use App\Http\Controllers\EstatusController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/estatus', [EstatusController::class, 'index']);
    Route::post('/estatus', [EstatusController::class, 'store']);
    Route::put('/estatus/{id}', [EstatusController::class, 'update']);
    Route::delete('/estatus/{id}', [EstatusController::class, 'destroy']);
});
