<?php

namespace App\Http\Controllers;

use App\Models\BaseDatosSiget;
use App\Models\catalogo\Biblioteca;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\TipoLuminaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $opcion = 1;
        if ($request->opcion) {
            $opcion = $request->opcion;
        }

        $departamento = 1;

        if ($request->departamento) {
            $departamento = $request->departamento;
        }

        $biblioteca = Biblioteca::where('activo', '=', '1')->get();

        $anio = BaseDatosSiget::max('anio');
        if ($anio) {
            $mes = BaseDatosSiget::where('anio', $anio)->max('mes');
        }

        /*if ($anio && $mes) {
            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->where('mes', $mes)
                ->where('anio', $anio)
                ->select('tipo_luminaria.nombre as tipo', DB::raw('SUM(base_datos_siget.consumo_mensual * numero_luminarias) as consumo_mensual'))
                ->groupBy('tipo_luminaria.nombre')
                ->get();
        } else {
            // Si no hay valores válidos para $anio y $mes, ejecutar la consulta sin esas condiciones
            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->select('tipo_luminaria.nombre as tipo', DB::raw('SUM(base_datos_siget.consumo_mensual * numero_luminarias) as consumo_mensual'))
                ->groupBy('tipo_luminaria.nombre')
                ->get();
        }*/

        if ($opcion == 1) {
            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->select('tipo_luminaria.nombre as tipo', DB::raw('SUM(base_datos_siget.consumo_mensual * numero_luminarias) as consumo_mensual'))
                ->groupBy('tipo_luminaria.nombre')
                ->get();
        } else {
            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->join('distrito', 'base_datos_siget.municipio_id', '=', 'distrito.codigo')
                ->join('municipio', 'distrito.municipio_id', '=', 'municipio.id')
                ->select('tipo_luminaria.nombre as tipo', DB::raw('SUM(base_datos_siget.consumo_mensual * numero_luminarias) as consumo_mensual'))
                ->where('municipio.departamento_id', $departamento)
                ->groupBy('tipo_luminaria.nombre')
                ->get();
        }

        $data_tipo_luminaria = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->tipo,
                "y" => $resultado->consumo_mensual + 0,
                "drilldown" => $resultado->tipo,
            ];
        })->all();



        /*if ($anio && $mes) {
            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->where('mes', $mes)
                ->where('anio', $anio)
                ->select('tipo_luminaria.nombre as tipo', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
                ->groupBy('tipo_luminaria.nombre')
                ->get();
        } else {
            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->select('tipo_luminaria.nombre as tipo', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
                ->groupBy('tipo_luminaria.nombre')
                ->get();
        }*/

        if ($opcion == 1) {
            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->select('tipo_luminaria.nombre as tipo', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
                ->groupBy('tipo_luminaria.nombre')
                ->get();
        } else {
            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->join('distrito', 'base_datos_siget.municipio_id', '=', 'distrito.codigo')
                ->join('municipio', 'distrito.municipio_id', '=', 'municipio.id')
                ->select('tipo_luminaria.nombre as tipo', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
                ->where('municipio.departamento_id', $departamento)
                ->groupBy('tipo_luminaria.nombre')
                ->get();
        }

        $data_numero_luminaria = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->tipo,
                "y" => $resultado->conteo + 0,
                "drilldown" => $resultado->tipo,
            ];
        })->all();


        //rangos
        $data_rango_potencia_instalada = [];
        if ($opcion == 1) {
            $tipo_luminarias = TipoLuminaria::where('activo', '1')
                ->withCount(['baseDatosSiget as potencias_count' => function ($query) use ($mes, $anio) {
                    $query->select(DB::raw('count(distinct potencia_nominal)'))->where('mes', $mes)
                        ->where('anio', $anio);
                }])->get();
        } else {
            $tipo_luminarias = TipoLuminaria::select('tipo_luminaria.id', 'tipo_luminaria.nombre')
                ->selectSub(function ($query) use ($departamento) {
                    $query->selectRaw('count(*)')
                        ->from('base_datos_siget as base')
                        ->join('distrito', 'base.municipio_id', '=', 'distrito.codigo')
                        ->join('municipio', 'distrito.municipio_id', '=', 'municipio.id')
                        ->whereColumn('municipio.departamento_id', '=', 'tipo_luminaria.id')
                        ->whereColumn('base.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                        ->where('municipio.departamento_id', $departamento);
                }, 'potencias_count')
                ->get();


        }

        foreach ($tipo_luminarias as $tipo) {
            $data_rango_potencia_instalada[] = [
                'name' => $tipo->nombre,
                'y' => $tipo->potencias_count + 0,
                'drilldown' => $tipo->nombre,
                'id' => $tipo->id
            ];
        }

        $meses = ["01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];

        $departamentos = Departamento::get();

        return view('welcome', compact('anio', 'mes', 'data_tipo_luminaria', 'data_numero_luminaria', 'data_rango_potencia_instalada', 'meses', 'opcion', 'departamentos'));
    }


    public function show_data($id, $anio, $mes)
    {
        if ($mes >= 1 && $mes <= 9) {
            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
        }

        $tipo = TipoLuminaria::findOrFail($id);
        $tipo_nombre =  $tipo->nombre;
        $resultados = DB::table('base_datos_siget')
            ->select('potencia_nominal', DB::raw('sum(numero_luminarias) as cantidad'))
            ->where('tipo_luminaria_id', $id)
            ->where('mes', $mes)
            ->where('anio', $anio)
            ->groupBy('potencia_nominal')
            ->get();

        $data_rango = [];
        foreach ($resultados as $resultado) {
            $data_rango[] = [
                'name' => $resultado->potencia_nominal . ' kwh',
                'y' => $resultado->cantidad + 0,
                'drilldown' => $resultado->potencia_nominal
            ];
        }
        $meses = ["01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];

        return view('data_potencia', compact('data_rango', 'tipo_nombre', 'anio', 'mes', 'meses'));
    }
}
