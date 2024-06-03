<?php

use App\Http\Controllers\catalogo\BibliotecaController;
use App\Http\Controllers\catalogo\DistritoController;
use App\Http\Controllers\catalogo\ReporteFallaController;
use App\Http\Controllers\control\ReporteFallaController as ControlReporteFallaController;
use App\Http\Controllers\catalogo\TipoFallaController;
use App\Http\Controllers\catalogo\TipoLuminariaController;
use App\Http\Controllers\catalogo\ValorKWHController;
use App\Http\Controllers\control\CensoLuminariaController;
use App\Http\Controllers\control\ComparacionCensosController;
use App\Http\Controllers\control\ValorEnergiaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\importacion\BaseDatosController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\publico\EvaluacionProyectosController;
use App\Http\Controllers\publico\ReporteFallaPublicoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\WelcomeController;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
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

Route::get('/', [WelcomeController::class, 'index'])->name('index');
// Route::get('/', function () {
//     return view('auth.login');
// });
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('home/rango_potencia_data/{id}/{anio}/{mes}', [HomeController::class,'show_data']);
Route::get('welcome/rango_potencia_data/{id}/{anio}/{mes}', [WelcomeController::class,'show_data']);


Route::resource('seguridad/permission', PermissionController::class);
Route::post('seguridad/permission/update_permission', [PermissionController::class, 'update_permission']);
Route::post('seguridad/user/attach_distrito', [UsuarioController::class, 'attach_distrito']);
Route::post('seguridad/user/dettach_distrito', [UsuarioController::class, 'dettach_distrito']);
Route::post('seguridad/user/attach_roles', [UsuarioController::class, 'attach_roles']);
Route::post('seguridad/user/dettach_roles', [UsuarioController::class, 'dettach_roles']);
Route::resource('seguridad/user', UsuarioController::class);
Route::resource('seguridad/role', RoleController::class);
Route::post('seguridad/role/unlink_permission', [RoleController::class, 'unlink_permission']);
Route::post('seguridad/role/link_permission', [RoleController::class, 'link_permission']);




Route::post('control/censo_luminaria/create_record', [CensoLuminariaController::class,'create_record']);
Route::get('control/censo_luminaria/show_map', [CensoLuminariaController::class,'show_map']);
Route::get('censo_luminaria/get_municipios/{id}', [CensoLuminariaController::class,'get_municipios']);
Route::get('censo_luminaria/get_companias/{id}', [CensoLuminariaController::class,'get_companias']);
Route::get('censo_luminaria/get_distritos/{id}', [CensoLuminariaController::class,'get_distritos']);
Route::get('censo_luminaria/get_potencia_promedio/{id}', [CensoLuminariaController::class,'get_potencia_promedio']);
Route::get('censo_luminaria/get_consumo_mensual/{id}', [CensoLuminariaController::class,'get_consumo_mensual']);
Route::resource('control/censo_luminaria', CensoLuminariaController::class);
Route::resource('control/valor_mensual_energia', ValorEnergiaController::class);

Route::resource('control/comparacion_censos', ComparacionCensosController::class);

//catalogos
Route::post('catalogo/biblioteca/active', [BibliotecaController::class,'active']);
Route::resource('catalogo/biblioteca', BibliotecaController::class);
Route::post('catalogo/tipo_luminaria/create_potencia', [TipoLuminariaController::class,'create_potencia']);
Route::get('catalogo/tipo_luminaria/create_tecnologia_sustituir/{id}/edit', [TipoLuminariaController::class,'create_tecnologia_sustituir']);
Route::post('catalogo/tipo_luminaria/store_tecnologia_sustituir/{id}', [TipoLuminariaController::class,'store_tecnologia_sustituir'])->name('tipo_luminaria.store_tecnologia_sustituir');
Route::delete('catalogo/tipo_luminaria/delete_tecnologia_sustituir/{id}', [TipoLuminariaController::class,'delete_tecnologia_sustituir'])->name('tipo_luminaria.delete_tecnologia_sustituir');
Route::resource('catalogo/tipo_luminaria', TipoLuminariaController::class);
Route::resource('catalogo/tipo_falla', TipoFallaController::class);

Route::resource('catalogo/valorkwh', ValorKWHController::class);


Route::get('catalogo/reporte_falla/get_distrito_id/{name}', [ReporteFallaController::class,'getDistritoId']);
Route::get('catalogo/reporte_falla/get_departamento_id/{name}', [ReporteFallaController::class,'getDepartamentoId']);
Route::resource('catalogo/distrito', DistritoController::class);
Route::resource('reporte_falla', ControlReporteFallaController::class);



//acceso publico
Route::get('publico/reporte_falla_publico/get_distritos/{id}', [ReporteFallaPublicoController::class,'get_distritos']);
Route::resource('publico/reporte_falla_publico', ReporteFallaPublicoController::class);
Route::get('publico/evaluacion_proyectos/get_grafico/{distrito}', [EvaluacionProyectosController::class,'get_grafico']);
Route::resource('publico/evaluacion_proyectos', EvaluacionProyectosController::class);
Route::get('publico/getConteoLuminaria', [EvaluacionProyectosController::class, 'getConteoLuminaria']);


Route::resource('importacion/base_datos', BaseDatosController::class);
Route::get('get_municipios/{id}',[DistritoController::class, 'get_municipios']);
Route::get('get_distritos/{id}',[DistritoController::class, 'get_distritos']);
Route::get('get_option/{id}',[DistritoController::class,'get_option']);

