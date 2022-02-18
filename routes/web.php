<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

//Rutas registrarse
Route::get('register', [RegisterController::class, 'mostrarFormulario'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
//Rutas para login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    //Ruta para cerrar sesión
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

require __DIR__.'/area.php';
require __DIR__.'/sala.php';
require __DIR__.'/estatus.php';
require __DIR__.'/curso.php';
require __DIR__.'/reportes.php';
require __DIR__.'/solicitud.php';
