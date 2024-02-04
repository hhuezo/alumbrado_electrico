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
            ->select('tipo_luminaria.nombre as tipo', DB::raw('SUM(base_datos_siget.consumo_mensual * numero_luminarias) as consumo_mensual'))
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

        $maxPotenciaNominal = DB::table('base_datos_siget')->max('potencia_nominal');

        $rangos = [[0, 36], [37, 72], [73, 148], [149, $maxPotenciaNominal]];

        $data_potencia_instalada = [];

        foreach ($rangos as $rango) {
            $resultado = DB::table('base_datos_siget')
                ->select(DB::raw('SUM(base_datos_siget.numero_luminarias) as total_conteo'))
                ->whereBetween('base_datos_siget.potencia_nominal', [$rango[0], $rango[1]])
                ->get();

            // Agrega el resultado de este rango específico al array de resultados
            $data_potencia_instalada[] = [
                'name' => $rango[0].' - '.$rango[1],
                'y' => $resultado[0]->total_conteo + 0,
                'drilldown' => $rango[0].' - '.$rango[1]
            ];
        }


        /*$resultados = DB::table('base_datos_siget')
            ->select(DB::raw('CONCAT(FLOOR((potencia_nominal - 1) / 200) * 200, "-", FLOOR((potencia_nominal - 1) / 200) * 200 + 199) as grupo_potencia'), DB::raw('SUM(numero_luminarias) as conteo'))
            ->groupBy(DB::raw('CONCAT(FLOOR((potencia_nominal - 1) / 200) * 200, "-", FLOOR((potencia_nominal - 1) / 200) * 200 + 199)'))
            ->orderBy('grupo_potencia')
            ->get();


        $data_potencia_instalada = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->grupo_potencia,
                "y" => $resultado->conteo + 0,
                "drilldown" => $resultado->grupo_potencia,
            ];
        })->all();*/


        $i = 1;



        $data_potencia_instalada_rango = null;
        foreach ($resultados as $item) {

            if (isset($rangos[$i - 1])) {
                $rango = $rangos[$i - 1];

                $resultados_rango = DB::table('base_datos_siget')
                    ->select('base_datos_siget.potencia_nominal as potencia_nominal', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
                    ->groupBy('base_datos_siget.potencia_nominal')
                    ->orderBy('base_datos_siget.potencia_nominal')
                    ->whereBetween('base_datos_siget.potencia_nominal', $rango)
                    ->get();

                if ($resultados_rango->count() > 0) {
                    // Guardar el resultado en el array con el índice $i
                    $data_potencia_instalada_rango[$i] = $resultados_rango->map(function ($resultado) {
                        return [
                            "name" => $resultado->potencia_nominal,
                            "y" => (int) $resultado->conteo, // Asegurarse de que sea un entero
                            "drilldown" => $resultado->potencia_nominal,
                        ];
                    })->all();
                    $i++; // Incrementar $i para el próximo índice
                }
            }
        }


        return view('home', compact('data_tipo_luminaria', 'data_numero_luminaria', 'data_potencia_instalada', 'data_potencia_instalada_rango'));
    }
}
