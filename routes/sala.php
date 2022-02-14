<?php

use App\Http\Controllers\SalaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/sala', [SalaController::class, 'index']);
    Route::post('/sala', [SalaController::class, 'store']);
    Route::put('/sala/{id}', [SalaController::class, 'update']);
    Route::delete('/sala/{id}', [SalaController::class, 'destroy']);
});
