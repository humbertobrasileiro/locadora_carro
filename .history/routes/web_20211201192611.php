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

Route::get('/marcas', function() {
    return view('app.marcas');
})->middleware('auth')->name('marcas');

Route::get('/carros', function() {
    return view('app.carros');
})->middleware('auth')->name('carros');

Route::get('/modelos', function() {
    return view('app.modelos');
})->middleware('auth')->name('modelos');

Route::get('/clientes', function() {
    return view('app.clientes');
})->middleware('auth')->name('clientes');
