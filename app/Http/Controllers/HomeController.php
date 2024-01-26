<?php

namespace App\Http\Controllers;

use App\Models\BaseDatosSiget;
use App\Models\catalogo\TipoLuminaria;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        //$data_siget = BaseDatosSiget::get();
        //grafico por tecnologia
        //$tipo_luminaria_array = TipoLuminaria::pluck('nombre', 'id')->toArray();

        $resultados = DB::table('base_datos_siget')
            ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
            ->select('tipo_luminaria.nombre as tipo', DB::raw('SUM(base_datos_siget.consumo_mensual) as consumo_mensual'))
            ->groupBy('tipo_luminaria.nombre')
            ->get();

        $data_tipo_luminaria = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->tipo,
                "y" => $resultado->consumo_mensual + 0,
                "drilldown" => $resultado->tipo,
            ];
        })->all();

        $resultados = DB::table('base_datos_siget')
        ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
        ->select('tipo_luminaria.nombre as tipo', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
        ->groupBy('tipo_luminaria.nombre')
        ->get();

        $data_numero_luminaria = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->tipo,
                "y" => $resultado->conteo + 0,
                "drilldown" => $resultado->tipo,
            ];
        })->all();


        $resultados = DB::table('base_datos_siget')
        ->select('base_datos_siget.potencia_nominal as potencia_nominal', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
        ->groupBy('base_datos_siget.potencia_nominal')
        ->orderBy('base_datos_siget.potencia_nominal')
        ->get();

        $data_potencia_instalada = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->potencia_nominal,
                "y" => $resultado->conteo + 0,
                "drilldown" => $resultado->potencia_nominal,
            ];
        })->all();



        return view('home', compact('data_tipo_luminaria','data_numero_luminaria','data_potencia_instalada'));
    }
}
