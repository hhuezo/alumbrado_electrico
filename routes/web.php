<?php

use App\Http\Controllers\control\CensoLuminariaController;
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

Route::get('censo_luminaria/get_municipios/{id}', [CensoLuminariaController::class,'get_municipios']);
Route::get('censo_luminaria/get_distritos/{id}', [CensoLuminariaController::class,'get_distritos']);
Route::get('censo_luminaria/get_potencia_promedio/{id}', [CensoLuminariaController::class,'get_potencia_promedio']);
Route::resource('control/censo_luminaria', CensoLuminariaController::class);
