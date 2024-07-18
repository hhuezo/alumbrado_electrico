<?php

namespace App\Http\Controllers\publico;

use App\Http\Controllers\Controller;
use App\Models\BaseDatosSiget;
use App\Models\BaseDatosSigetTemp;
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
                'base_datos_siget.id as id',
                'tipo_luminaria.nombre as tipo',
                'tipo_luminaria.id as tipo_id',
                DB::raw('SUM(base_datos_siget.numero_luminarias) as conteo'),
                'distrito.nombre',
                'base_datos_siget.potencia_nominal',
                DB::raw('base_datos_siget.consumo_mensual as consumo_mensual')
            )
            ->where('distrito.codigo', $request->distrito)
            ->where('base_datos_siget.anio', $anio)
            ->where('base_datos_siget.mes', $mes)
            ->where('base_datos_siget.potencia_nominal', '<>', null)
            ->where('base_datos_siget.consumo_mensual', '<>', null)
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

        $tecnologia_actual_array = $request->input('tecnologia_actual_array');

        if ($tecnologia_actual_array != null) {

            if ($request->tipo == 1) {

                $registros_siget = BaseDatosSiget::whereIn('id', $tecnologia_actual_array)->get();

                $potencia_promedio_array = [];

                foreach ($registros_siget as $registro) {
                    $potencia_promedio = PotenciaPromedio::where('tipo_luminaria_id', $registro->tipo_luminaria_id)
                        ->where('potencia', $registro->potencia_nominal)->first();
                    if ($potencia_promedio != null) {
                        array_push($potencia_promedio_array, $potencia_promedio->id);
                    }
                }


                $tecnologia_sustituir = TecnologiaSustituir::whereIn('tecnologia_actual_id', $potencia_promedio_array)->get();


                $tecnologias_sustituir_array = $tecnologia_sustituir->pluck('tecnologia_sustituir_id')->unique()->toArray();

                $potencias_finales = PotenciaPromedio::whereIn('id', $tecnologias_sustituir_array)->get();
            } else {

                $registros_censo = CensoLuminaria::whereIn('id', $tecnologia_actual_array)->get();


                $potencia_promedio_array = [];

                foreach ($registros_censo as $registro) {

                    $potencia_promedio = PotenciaPromedio::where('tipo_luminaria_id', $registro->tipo_luminaria_id)
                        ->where('potencia', $registro->potencia_nominal)->first();

                    if ($potencia_promedio != null) {
                        array_push($potencia_promedio_array, $potencia_promedio->id);
                    }
                }

                $tecnologia_sustituir = TecnologiaSustituir::whereIn('tecnologia_actual_id', $potencia_promedio_array)->get();


                $tecnologias_sustituir_array = $tecnologia_sustituir->pluck('tecnologia_sustituir_id')->unique()->toArray();

                $potencias_finales = PotenciaPromedio::whereIn('id', $tecnologias_sustituir_array)->get();
            }
        } else {
            $potencias_finales = [];
        }


        //dd($potencias_finales|);



        return view('publico.combo_tecnologias_sustituir_', compact('potencias_finales'));
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
            ->where('base_datos_siget.potencia_nominal', '<>', null)
            ->where('base_datos_siget.consumo_mensual', '<>', null)
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

    public function get_grafico_sugerido(Request $request)
    {
        if ($request->tipo == 1) {
            $distrito_id = $request->distrito;
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


            $base_siget = DB::table('base_datos_siget')
                ->join('distrito', 'distrito.codigo', '=', 'base_datos_siget.municipio_id')
                ->select('tipo_luminaria_id', 'potencia_nominal', DB::raw('sum(numero_luminarias) numero_luminarias'))
                ->where('distrito.codigo', $distrito_id)
                ->where('base_datos_siget.anio', $anio)
                ->where('base_datos_siget.mes', $mes)
                ->where('base_datos_siget.potencia_nominal', '<>', null)
                ->where('base_datos_siget.consumo_mensual', '<>', null)
                ->groupBy('tipo_luminaria_id', 'potencia_nominal')
                ->get();


            BaseDatosSigetTemp::where('user_id', auth()->user()->id)->delete();

            foreach ($base_siget as $record) {
                $temp = new BaseDatosSigetTemp();
                $temp->municipio_id = $distrito_id;
                $temp->tipo_luminaria_id = $record->tipo_luminaria_id;
                $temp->potencia_nominal = $record->potencia_nominal;
                $temp->numero_luminarias = $record->numero_luminarias;
                $temp->user_id = auth()->user()->id;
                $temp->save();
            }



            $potencia_promedio = PotenciaPromedio::findOrFail($request->tecnologia_sustituir_id);

            $tecnologiaSustituirArray = json_decode($request->tecnologia_sustituir, true);

            //dd($potencia_promedio, $tecnologiaSustituirArray);

            foreach ($tecnologiaSustituirArray as $record) {
                $numero_luminarias = intval($record['numero_luminarias']);

                //dismunuyendo el numero de luminarias de la potencia actual
                $temp = new BaseDatosSigetTemp();
                $temp->municipio_id = $distrito_id;
                $temp->tipo_luminaria_id = $record['tipo_luminaria_id'];
                $temp->potencia_nominal = $record['potencia_nominal'];
                $temp->numero_luminarias = $numero_luminarias  * -1;
                $temp->user_id = auth()->user()->id;
                $temp->save();


                //agregandola a la potencia a sustituir
                $temp = new BaseDatosSigetTemp();
                $temp->municipio_id = $distrito_id;
                $temp->tipo_luminaria_id = $potencia_promedio->tipo_luminaria_id;
                $temp->potencia_nominal = $potencia_promedio->potencia;
                $temp->numero_luminarias = $numero_luminarias;
                $temp->user_id = auth()->user()->id;
                $temp->save();
            }


            $resultados = DB::table('base_datos_siget_temp')
                ->join('tipo_luminaria', 'base_datos_siget_temp.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->join('distrito', 'distrito.codigo', '=', 'base_datos_siget_temp.municipio_id')
                ->select(
                    'tipo_luminaria.id as tipo_id',
                    'tipo_luminaria.nombre as tipo',
                    DB::raw('SUM(base_datos_siget_temp.numero_luminarias) as conteo'),
                    'distrito.nombre',
                    'distrito.id',
                    DB::raw('base_datos_siget_temp.consumo_mensual as consumo_mensual')
                )
                ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre')
                ->get();

            $data_numero_luminaria = $resultados->map(function ($resultado) {
                return [
                    "name" => $resultado->tipo,
                    "y" => $resultado->conteo + 0,
                    "drilldown" => $resultado->tipo,
                ];
            })->all();
        } else {

            $distrito_id = $request->distrito;
            $resultados = DB::table('censo_luminaria')
                ->join('tipo_luminaria', 'censo_luminaria.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->join('distrito', 'distrito.id', '=', 'censo_luminaria.distrito_id')
                ->select(
                    'tipo_luminaria.id as tipo_luminaria_id',
                    'tipo_luminaria.nombre as tipo',
                    DB::raw('COUNT(*) as numero_luminarias'),
                    'distrito.nombre',
                    'censo_luminaria.potencia_nominal'
                )
                ->where('distrito.codigo', $distrito_id)
                ->where('censo_luminaria.potencia_nominal', '<>', null)
                ->where('censo_luminaria.consumo_mensual', '<>', null)
                ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre')
                ->get();

            BaseDatosSigetTemp::where('user_id', auth()->user()->id)->delete();

            foreach ($resultados as $record) {
                $temp = new BaseDatosSigetTemp();
                $temp->municipio_id = $distrito_id;
                $temp->tipo_luminaria_id = $record->tipo_luminaria_id;
                $temp->potencia_nominal = $record->potencia_nominal;
                $temp->numero_luminarias = $record->numero_luminarias;
                $temp->user_id = auth()->user()->id;
                $temp->save();
            }


            $potencia_promedio = PotenciaPromedio::findOrFail($request->tecnologia_sustituir_id);

            $tecnologiaSustituirArray = json_decode($request->tecnologia_sustituir, true);

            //dd($potencia_promedio, $tecnologiaSustituirArray);

            foreach ($tecnologiaSustituirArray as $record) {
                $numero_luminarias = intval($record['numero_luminarias']);

                //dismunuyendo el numero de luminarias de la potencia actual
                $temp = new BaseDatosSigetTemp();
                $temp->municipio_id = $distrito_id;
                $temp->tipo_luminaria_id = $record['tipo_luminaria_id'];
                $temp->potencia_nominal = $record['potencia_nominal'];
                $temp->numero_luminarias = $numero_luminarias  * -1;
                $temp->user_id = auth()->user()->id;
                $temp->save();


                //agregandola a la potencia a sustituir
                $temp = new BaseDatosSigetTemp();
                $temp->municipio_id = $distrito_id;
                $temp->tipo_luminaria_id = $potencia_promedio->tipo_luminaria_id;
                $temp->potencia_nominal = $potencia_promedio->potencia;
                $temp->numero_luminarias = $numero_luminarias;
                $temp->user_id = auth()->user()->id;
                $temp->save();
            }


            $resultados = DB::table('base_datos_siget_temp')
                ->join('tipo_luminaria', 'base_datos_siget_temp.tipo_luminaria_id', '=', 'tipo_luminaria.id')
                ->join('distrito', 'distrito.codigo', '=', 'base_datos_siget_temp.municipio_id')
                ->select(
                    'tipo_luminaria.id as tipo_id',
                    'tipo_luminaria.nombre as tipo',
                    DB::raw('SUM(base_datos_siget_temp.numero_luminarias) as conteo'),
                    'distrito.nombre',
                    'distrito.id',
                    DB::raw('base_datos_siget_temp.consumo_mensual as consumo_mensual')
                )
                ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre')
                ->having('conteo', '>', 0)
                ->get();

            $data_numero_luminaria = $resultados->map(function ($resultado) {
                return [
                    "name" => $resultado->tipo,
                    "y" => $resultado->conteo + 0,
                    "drilldown" => $resultado->tipo,
                ];
            })->all();


            return view('publico.grafico_sugerido', compact('data_numero_luminaria'));
        }




        return view('publico.grafico_sugerido', compact('data_numero_luminaria',  'anio', 'mes'));

        //dd($potencia_promedio);
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
                'censo_luminaria.id as id',
                'tipo_luminaria.nombre as tipo',
                'tipo_luminaria.id as tipo_id',
                DB::raw('COUNT(*) as conteo'),
                'distrito.nombre',
                'censo_luminaria.potencia_nominal',
                DB::raw('censo_luminaria.consumo_mensual as consumo_mensual')
            )
            ->where('distrito.codigo', $request->distrito)
            ->where('censo_luminaria.potencia_nominal', '<>', null)
            ->where('censo_luminaria.consumo_mensual', '<>', null)
            ->groupBy('distrito.nombre', 'distrito.id', 'tipo_luminaria.nombre', 'censo_luminaria.potencia_nominal', 'tipo_luminaria.id')
            ->get();

        $tipo_id_array =  $resultados->pluck('tipo_id')->toArray();
        $tipos = TipoLuminaria::whereIn('id', $tipo_id_array)->get();

        $configuracion = Configuracion::first();

        return view('publico.eva', compact('resultados', 'tipos', 'configuracion'));
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
            ->where('censo_luminaria.potencia_nominal', '<>', null)
            ->where('censo_luminaria.consumo_mensual', '<>', null)
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
