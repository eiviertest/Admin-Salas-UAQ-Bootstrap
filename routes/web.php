<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/enrolarse', [CursoPersonaController::class, 'enrolarse_curso']);
    Route::post('/rechazar_persona_curso', [CursoPersonaController::class, 'rechazar_persona_curso']);
    Route::post('/aceptar_persona_curso', [CursoPersonaController::class, 'aceptar_persona_curso']);
});

require __DIR__.'/area.php';
require __DIR__.'/sala.php';
require __DIR__.'/estatus.php';
require __DIR__.'/curso.php';
require __DIR__.'/reportes.php';
