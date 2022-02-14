<?php

use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/area', [AreaController::class, 'index']);
    Route::post('/area', [AreaController::class, 'store']);
    Route::put('/area/{id}', [AreaController::class, 'update']);
    Route::delete('/area/{id}', [AreaController::class, 'destroy']);
});
