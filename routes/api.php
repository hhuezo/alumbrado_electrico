<?php
use App\Http\Controllers\api\ReporteFallaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
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

Route::get('/', function () {
    dd("");
    $message = "Hola, este es un mensaje JSON.";

    return Response::json(['message' => $message]);
});
Route::get('api_get_distritos/{id}', [ReporteFallaController::class,'getDistritos']);
Route::resource('api_reporte_falla', ReporteFallaController::class);
