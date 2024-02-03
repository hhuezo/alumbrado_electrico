<?php

use App\Http\Controllers\catalogo\BibliotecaController;
use App\Http\Controllers\catalogo\ReporteFallaController;
use App\Http\Controllers\control\CensoLuminariaController;
use App\Http\Controllers\importacion\BaseDatosController;
use App\Http\Controllers\publico\ReporteFallaPublicoController;
use App\Http\Controllers\WelcomeController;
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


Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/', [WelcomeController::class, 'index'])->name('index');
Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('control/censo_luminaria/show_map', [CensoLuminariaController::class,'show_map']);
Route::get('censo_luminaria/get_municipios/{id}', [CensoLuminariaController::class,'get_municipios']);
Route::get('censo_luminaria/get_distritos/{id}', [CensoLuminariaController::class,'get_distritos']);
Route::get('censo_luminaria/get_potencia_promedio/{id}', [CensoLuminariaController::class,'get_potencia_promedio']);
Route::get('censo_luminaria/get_consumo_mensual/{id}', [CensoLuminariaController::class,'get_consumo_mensual']);
Route::resource('control/censo_luminaria', CensoLuminariaController::class);

Route::post('catalogo/biblioteca/active', [BibliotecaController::class,'active']);
Route::resource('catalogo/biblioteca', BibliotecaController::class);



Route::get('catalogo/reporte_falla/get_distrito_id/{name}', [ReporteFallaController::class,'getDistritoId']);
Route::get('catalogo/reporte_falla/get_departamento_id/{name}', [ReporteFallaController::class,'getDepartamentoId']);
Route::resource('catalogo/reporte_falla', ReporteFallaController::class);



//acceso publico
Route::get('publico/reporte_falla_publico/get_distritos/{id}', [ReporteFallaPublicoController::class,'get_distritos']);
Route::resource('publico/reporte_falla_publico', ReporteFallaPublicoController::class);

Route::resource('importacion/base_datos', BaseDatosController::class);
