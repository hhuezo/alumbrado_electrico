<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\BaseDatosSiget;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\TipoLuminaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstimacionFacturaGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $verificacion_data = BaseDatosSiget::count('id');

        $mes = null;
        $anio = null;
        $id_distrito = null;
        $id_municipio = null;
        $id_departamento = null;
        $nombre_distrito = 'Todos';
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
            $id_distrito = array();
            $dis  = Distrito::findOrFail($request->id_distrito);
            array_push($id_distrito, $dis->codigo);
            $nombre_distrito = $dis->nombre;
        } else {
            //$id_distrito = array();
            $dis  = Distrito::where('municipio_id', $request->municipio)->get();
            $id_distrito = $dis->pluck('codigo')->toArray();
            $id_distrito = $dis->pluck('codigo')->toArray();
        }

        if ($verificacion_data > 0) {


            $resultados = DB::table('base_datos_siget')
                ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->join('distrito', 'distrito.codigo', '=', 'base_datos_siget.municipio_id')
                ->join('compania', 'compania.id', '=', 'base_datos_siget.compania_id')
                ->select(
                    'distrito.codigo as distrito_codigo',
                    DB::raw("distrito.nombre AS distrito"),
                    DB::raw('SUM(base_datos_siget.numero_luminarias) AS conteo'),
                    DB::raw('SUM( distinct base_datos_siget.total_pagar) as total_pagar ')
                );
            if ($anio && $mes && $id_distrito) {
                $resultados->where('base_datos_siget.anio', $anio)
                    ->where('base_datos_siget.mes', $mes)
                    ->whereIn('distrito.codigo', $id_distrito);
            }
            $resultados->whereNotNull('base_datos_siget.potencia_nominal')
                ->whereNotNull('base_datos_siget.consumo_mensual')
                ->groupBy('distrito.id');

            $resultados = $resultados->get(); // Obtener los resultados de la consulta

            $data_base_siget = $resultados->map(function ($resultado) {
                return [
                    "name" => $resultado->distrito,
                    "y" => $resultado->total_pagar + 0,
                    "drilldown" => $resultado->distrito,
                ];
            })->all();
            //dd($data_base_siget);


            $resultados = DB::table('gasto_mensual_censo_luminaria_view')
                ->select(
                    'distrito_codigo',
                    DB::raw("distritos AS distritos"),
                    'compania_nombre as distribuidora',
                    DB::raw('SUM(total_luminarias) AS total_luminarias'),
                    DB::raw('SUM(cantidad_de_kwh_usados_por_mes) AS total_kwh_usados_por_mes'),
                    DB::raw('cargo_comercializacion_fijo + (cargo_energia_variable * SUM(cantidad_de_kwh_usados_por_mes)) + (cargo_distribucion_variable * SUM(cantidad_de_kwh_usados_por_mes)) AS gasto_total_mensual')
                );
            if ($id_distrito) {
                $resultados->whereIn('distrito_codigo', $id_distrito);
            }
            $resultados->groupBy('distrito_codigo', 'compania_id');
            $resultados = $resultados->get();


            $data_censo_luminaria = $resultados->groupBy('distrito_codigo')->map(function ($grupo) {
                return [
                    //'distrito_codigo' => $grupo->first()->distrito_codigo,
                    'name' => $grupo->first()->distritos,
                    //'total_luminarias' => $grupo->sum('total_luminarias'),
                    //'total_kwh_usados_por_mes' => $grupo->sum('total_kwh_usados_por_mes'),
                    'y' => $grupo->sum('gasto_total_mensual') + 0,
                    'drilldown' => $grupo->first()->distritos,
                ];
            })->values();

            // Crear un array temporal para la comparación
            $temp_data_censo = [];
            foreach ($data_censo_luminaria as $censo) {
                $temp_data_censo[$censo['name']] = $censo['y'];
            }

            // Calcular la diferencia entre los dos conjuntos de datos
            $diferencia_data = collect($data_base_siget)->map(function ($base_siget) use ($temp_data_censo) {
                if (isset($temp_data_censo[$base_siget['name']])) {
                    $censo_y =  $temp_data_censo[$base_siget['name']];
                    $diferencia_y = $base_siget['y'] - $censo_y;
                    return [
                        "name" => $base_siget['name'],
                        "y" => $diferencia_y,
                        "drilldown" => $base_siget['drilldown'],
                    ];
                }
            })->values();
            //dd($diferencia_data);
        } else {
            $data_base_siget = null;
            $data_censo_luminaria = null;
            $diferencia_data = null;
        }


        $meses = ["01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];
        $departamentos = Departamento::get();
        if ($request->departamento) {
            $id_departamento = $request->departamento;
            $municipios = Municipio::where('departamento_id', $request->departamento)->get();
        } else {
            $municipios = null;
        }

        if ($request->municipio) {
            $id_municipio = $request->municipio;
            $distritos = Distrito::where('municipio_id', $request->municipio)->get();
        } else {
            $distritos = null;
        }

        if ($request->id_distrito) {
            $id_distrito = $request->id_distrito;
        }



        return view('estimacion_factura_general.index', compact(
            'nombre_distrito',
            'departamentos',
            'municipios',
            'distritos',
            'anio',
            'mes',
            'data_base_siget',
            'data_censo_luminaria',
            'diferencia_data',
            'meses',
            'verificacion_data',
            'id_departamento',
            'id_municipio',
            'id_distrito',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
