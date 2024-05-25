<?php

namespace App\Http\Controllers\publico;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
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

        $resultados = DB::table('base_datos_siget')
        ->join('tipo_luminaria', 'base_datos_siget.tipo_luminaria_id', '=', 'tipo_luminaria.id')
        ->join('distrito', 'distrito.codigo', '=', 'base_datos_siget.municipio_id')
        ->select(
            'tipo_luminaria.nombre as tipo',
            DB::raw('SUM(base_datos_siget.numero_luminarias) as conteo'),
            'distrito.nombre',
            'distrito.id',
            'base_datos_siget.potencia_nominal',
            DB::raw('base_datos_siget.consumo_mensual as consumo_mensual')
        )
        ->where('distrito.codigo', $request->distrito)
        ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre', 'base_datos_siget.potencia_nominal')
        ->get();
        /*$resultados = DB::table('censo_luminaria')
        ->join('tipo_luminaria', 'censo_luminaria.tipo_luminaria_id', '=', 'tipo_luminaria.id')
        ->where('distrito_id', $request->distrito)
        ->select('tipo_luminaria.nombre as tipo', DB::raw('COUNT(*) as conteo'))
        ->groupBy('tipo_luminaria.nombre')
        ->get();*/

        $data_numero_luminaria = $resultados->map(function ($resultado) {
            return [
                "name" => $resultado->tipo.' '.$resultado->potencia_nominal.' Vatios',
                "y" => $resultado->conteo + 0,
                "drilldown" => $resultado->tipo,
            ];
        })->all();

        return view('publico.eva', compact('resultados','data_numero_luminaria'));

        //return response()->json($data_numero_luminaria);
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
