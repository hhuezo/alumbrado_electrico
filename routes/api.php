<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CensoLuminariaController;
use App\Http\Controllers\api\ReporteFallaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


// Ruta para iniciar sesión
Route::post('/login', [AuthController::class,'login']);
// Ruta para cerrar sesión
Route::post('/logout', [AuthController::class,'logout']);


Route::get('api_get_distrito_id/{name}', [ReporteFallaController::class,'getDistritoId']);
Route::get('api_get_municipio_id/{id}', [ReporteFallaController::class,'getMunicipioId']);
Route::get('api_get_departamento_id/{name}', [ReporteFallaController::class,'getDepartamentoId']);
Route::get('api_get_municipios/{id}', [ReporteFallaController::class,'getMunicipios']);
Route::get('api_get_distritos/{id}', [ReporteFallaController::class,'getDistritos']);
Route::resource('api_reporte_falla', ReporteFallaController::class);

Route::get('api_censo_luminaria/get_data_create/{departamento}/{distrito}', [CensoLuminariaController::class,'get_data_create']);
Route::get('api_censo_luminaria/get_potencia_promedio/{id}', [CensoLuminariaController::class,'get_potencia_promedio']);
Route::get('api_censo_luminaria/get_consumo_mensual/{id}', [CensoLuminariaController::class,'get_consumo_mensual']);
Route::resource('api_censo_luminaria', CensoLuminariaController::class);
