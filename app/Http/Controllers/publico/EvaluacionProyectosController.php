<?php

namespace App\Http\Controllers\publico;

use App\Http\Controllers\Controller;
use App\Models\BaseDatosSiget;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\catalogo\TecnologiaSustituir;
use App\Models\catalogo\TipoLuminaria;
use App\Models\Configuracion;
use App\Models\control\CensoLuminaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluacionProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos = Departamento::get();
        //$municipios =  Municipio::where('departamento_id', $id_departamento)->get();
        return view('publico.evaluacion_proyectos', compact(
            'departamentos'
        ));
    }

    public function getConteoLuminaria(Request $request)
    {

        $result = DB::table('base_datos_siget')
            ->selectRaw('MAX(anio) as max_anio')
            ->selectSub(function ($query) {
                $query->from('base_datos_siget')
                    ->whereColumn('anio', DB::raw('(SELECT MAX(anio) FROM base_datos_siget)'))
                    ->selectRaw('MAX(mes) as max_mes');
            }, 'max_mes')
            ->first();

        $anio = $result->max_anio;
        $mes = $result->max_mes + 0;

        $resultados = BaseDatosSiget::join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
            ->join('distrito', 'distrito.codigo', '=', 'base_datos_siget.municipio_id')
            ->select(
                'tipo_luminaria.nombre as tipo',
                'tipo_luminaria.id as tipo_id',
                DB::raw('SUM(base_datos_siget.numero_luminarias) as conteo'),
                'distrito.nombre',
                'distrito.id',
                'base_datos_siget.potencia_nominal',
                DB::raw('base_datos_siget.consumo_mensual as consumo_mensual')
            )
            ->where('distrito.codigo', $request->distrito)
            ->where('base_datos_siget.anio', $anio)
            ->where('base_datos_siget.mes', $mes)
            ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre', 'base_datos_siget.potencia_nominal', 'tipo_luminaria.id')
            ->get();

        $tipo_id_array =  $resultados->pluck('tipo_id')->toArray();
        $tipos = TipoLuminaria::whereIn('id', $tipo_id_array)->get();

        //dd($tipo_id_array,$tipos);
        //dd($resultados, $resultadosCenso);

        $configuracion = Configuracion::first();

        return view('publico.eva', compact('resultados',  'tipos', 'anio', 'mes', 'configuracion'));
    }

    public function getTecnologiasSugeridas(Request $request)
    {
        //dd($request->input('tecnologia_actual_array'), "datos_enviados");

        $datos = $request->input('tecnologia_actual_array');


        $resultados = [];
        foreach ($datos as $dato) {
            //dd($dato['tipo_id'],$dato['potencia_nominal'],$dato['consumo_mensual_kwh'], "primer registro");

            $registro = PotenciaPromedio::where('tipo_luminaria_id', (int) $dato['tipo_id'])
                ->where('potencia', (string) $dato['potencia_nominal'])
                ->where('consumo_promedio', (float) $dato['consumo_mensual_kwh'])
                ->first();
            //dd($registro,"Tecnologia1");

            if ($registro) {
                $resultados[] = $registro->id;
            }
        }


        $tecnologiasRemplazar = TecnologiaSustituir::whereIn('tecnologia_actual_id', $resultados)->get();
        $sustituir_id_array =  $tecnologiasRemplazar->pluck('tecnologia_sustituir_id')->toArray();
        $tecnologiasRemplazar = PotenciaPromedio::whereIn('id', $sustituir_id_array)->get();
        //dd($tecnologiasRemplazar);

        return view('publico.combo_tecnologias_sustituir_', compact('tecnologiasRemplazar'));
    }


    public function get_grafico($distrito_id)
    {
        $result = DB::table('base_datos_siget')
            ->selectRaw('MAX(anio) as max_anio')
            ->selectSub(function ($query) {
                $query->from('base_datos_siget')
                    ->whereColumn('anio', DB::raw('(SELECT MAX(anio) FROM base_datos_siget)'))
                    ->selectRaw('MAX(mes) as max_mes');
            }, 'max_mes')
            ->first();

        $anio = $result->max_anio;
        $mes = $result->max_mes + 0;


        $resultados = DB::table('base_datos_siget')
            ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
            ->join('distrito', 'distrito.codigo', '=', 'base_datos_siget.municipio_id')
            ->select(
                'tipo_luminaria.id as tipo_id',
                'tipo_luminaria.nombre as tipo',
                DB::raw('SUM(base_datos_siget.numero_luminarias) as conteo'),
                'distrito.nombre',
                'distrito.id',
                DB::raw('base_datos_siget.consumo_mensual as consumo_mensual')
            )
            ->where('distrito.codigo', $distrito_id)
            ->where('base_datos_siget.anio', $anio)
            ->where('base_datos_siget.mes', $mes)
            ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre')
            ->get();

        $data_numero_luminaria = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->tipo,
                "y" => $resultado->conteo + 0,
                "drilldown" => $resultado->tipo,
            ];
        })->all();

        return view('publico.grafico', compact('data_numero_luminaria',  'anio', 'mes'));
    }

    public function evaluacionProyectosCensoIndex()
    {
        $departamentos = Departamento::get();
        return view('publico.evaluacion_proyectos_censo', compact(
            'departamentos'
        ));
    }

    public function getConteoLuminariaCenso(Request $request)
    {
        $resultados = CensoLuminaria::join('tipo_luminaria', 'censo_luminaria.tipo_luminaria_id', '=', 'tipo_luminaria.id')
            ->join('distrito', 'distrito.id', '=', 'censo_luminaria.distrito_id')
            ->select(
                'tipo_luminaria.nombre as tipo',
                'tipo_luminaria.id as tipo_id',
                DB::raw('COUNT(*) as conteo'),
                'distrito.nombre',
                'distrito.id',
                'censo_luminaria.potencia_nominal',
                DB::raw('censo_luminaria.consumo_mensual as consumo_mensual')
            )
            ->where('distrito.codigo', $request->distrito)
            ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre', 'censo_luminaria.potencia_nominal', 'tipo_luminaria.id')
            ->get();

        $tipo_id_array =  $resultados->pluck('tipo_id')->toArray();
        $tipos = TipoLuminaria::whereIn('id', $tipo_id_array)->get();

        $configuracion = Configuracion::first();

        return view('publico.eva', compact('resultados','tipos','configuracion'));
    }

    public function getGraficoCenso($distrito_id)
    {
        $resultados = DB::table('censo_luminaria')
            ->join('tipo_luminaria', 'censo_luminaria.tipo_luminaria_id', '=', 'tipo_luminaria.id')
            ->join('distrito', 'distrito.id', '=', 'censo_luminaria.distrito_id')
            ->select(
                'tipo_luminaria.id as tipo_id',
                'tipo_luminaria.nombre as tipo',
                DB::raw('COUNT(*) as conteo'),
                'distrito.nombre',
                'distrito.id',
                DB::raw('censo_luminaria.consumo_mensual as consumo_mensual')
            )
            ->where('distrito.codigo', $distrito_id)
            ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre')
            ->get();

        $data_numero_luminaria = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->tipo,
                "y" => $resultado->conteo + 0,
                "drilldown" => $resultado->tipo,
            ];
        })->all();
        //dd($data_numero_luminaria);
        return view('publico.grafico', compact('data_numero_luminaria'));
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
        dd('Metodo show');
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
