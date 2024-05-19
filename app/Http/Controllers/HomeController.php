<?php

namespace App\Http\Controllers;

use App\Models\BaseDatosSiget;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\TipoLuminaria;
use Illuminate\Http\Request;
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

    public function index(Request $request)
    {
        $verificacion_data = BaseDatosSiget::count('id');

        $mes = null;
        $anio = null;
        $id_distrito = null;
        if ($request->mes) {
            $mes  = $request->mes;
        }

        if ($request->anio) {
            $anio  = $request->anio;
        } else {
            $anio = BaseDatosSiget::max('anio');
            if ($anio) {
                $mes = BaseDatosSiget::where('anio', $anio)->max('mes');
            }
        }

        if ($request->id_distrito) {
            $id_distrito  = $request->id_distrito;
        }
      

        if ($verificacion_data > 0) {

            if ($anio && $mes && $id_distrito) {
                $resultados = DB::table('base_datos_siget')
                    ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                    ->where('mes', $mes)
                    ->where('anio', $anio)
                    ->where('municipio_id',$id_distrito)
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
            }

            $data_tipo_luminaria = $resultados->map(function ($resultado) {
                return [
                    "name" => $resultado->tipo,
                    "y" => $resultado->consumo_mensual + 0,
                    "drilldown" => $resultado->tipo,
                ];
            })->all();
            if ($anio && $mes && $id_distrito) {
                $resultados = DB::table('base_datos_siget')
                    ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                    ->where('mes', $mes)
                    ->where('anio', $anio)
                    ->where('municipio_id',$id_distrito)
                    ->select('tipo_luminaria.nombre as tipo', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
                    ->groupBy('tipo_luminaria.nombre')
                    ->get();
            } else {
                $resultados = DB::table('base_datos_siget')
                    ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                    ->select('tipo_luminaria.nombre as tipo', DB::raw('sum(base_datos_siget.numero_luminarias) as conteo'))
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
            $tipo_luminarias = TipoLuminaria::where('activo', '1')
                ->withCount(['baseDatosSiget as potencias_count' => function ($query) use ($mes, $anio) {
                    $query->select(DB::raw('count(distinct potencia_nominal)'))->where('mes', $mes)
                        ->where('anio', $anio);
                }])->get();


            foreach ($tipo_luminarias as $tipo) {
                $data_rango_potencia_instalada[] = [
                    'name' => $tipo->nombre,
                    'y' => $tipo->potencias_count + 0,
                    'drilldown' => $tipo->nombre,
                    'id' => $tipo->id
                ];
            }
        }
        else{
            $data_tipo_luminaria = null;
            $data_numero_luminaria = null;
            $data_rango_potencia_instalada = null;
        }
        $meses = ["01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];
        $departamentos = Departamento::get();
        $municipios = Municipio::get();
        $distritos = Distrito::get();
        return view('home', compact('departamentos','municipios','distritos','anio', 'mes', 'data_tipo_luminaria', 'data_numero_luminaria', 'data_rango_potencia_instalada', 'meses','verificacion_data'));
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
