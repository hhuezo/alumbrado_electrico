<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\BaseDatosSiget;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComparacionCensosController extends Controller
{

    public function index(Request $request)
    {
        $departamentos = Departamento::get();
        $nombreDistrito = "";

        // Obtener el máximo año
        $maxAnio = BaseDatosSiget::max('anio');

        // Obtener el registro con el máximo mes dentro del máximo año
        $result = BaseDatosSiget::where('anio', $maxAnio)
            ->orderBy('mes', 'desc')
            ->first(['anio', 'mes']);

        if ($result) {
            $maxAnio = $result->anio;
            $maxMes = $result->mes;

        }

        $meses = [
            '01' => 'ENERO',
            '02' => 'FEBRERO',
            '03' => 'MARZO',
            '04' => 'ABRIL',
            '05' => 'MAYO',
            '06' => 'JUNIO',
            '07' => 'JULIO',
            '08' => 'AGOSTO',
            '09' => 'SEPTIEMBRE',
            '10' => 'OCTUBRE',
            '11' => 'NOVIEMBRE',
            '12' => 'DICIEMBRE'
        ];

        if ($request->id_distrito) {
            $distrito = Distrito::findOrFail($request->id_distrito);
            $nombreDistrito = $distrito->nombre;
            $tiposLuminarias = DB::table('tipo_luminaria')
                ->select(
                    'tipo_luminaria.id',
                    'tipo_luminaria.nombre as tipo',
                    DB::raw('(
                        SELECT COALESCE(SUM(base_datos_siget.numero_luminarias), 0)
                        FROM base_datos_siget
                        INNER JOIN distrito ON distrito.codigo = base_datos_siget.municipio_id
                        WHERE base_datos_siget.tipo_luminaria_id = tipo_luminaria.id
                        AND distrito.id = ' . $request->id_distrito . '
                        AND base_datos_siget.anio = ' . $maxAnio . '
                        AND base_datos_siget.mes = "' . $maxMes . '"
                    ) as suma_luminarias'),
                    DB::raw('(
                        SELECT COUNT(censo_luminaria.id)
                        FROM censo_luminaria
                        INNER JOIN distrito ON censo_luminaria.distrito_id = distrito.id
                        WHERE censo_luminaria.tipo_luminaria_id = tipo_luminaria.id
                        AND distrito.id = ' . $request->id_distrito . '
                    ) as total_censo_luminarias')
                )->get();
        } else {
            $tiposLuminarias = DB::table('tipo_luminaria')
                ->select(
                    'tipo_luminaria.nombre as tipo',
                    DB::raw('COALESCE(SUM(base_datos_siget.numero_luminarias), 0) as suma_luminarias'),
                    DB::raw('COALESCE(censo.total_censo_luminarias, 0) as total_censo_luminarias')
                )
                ->leftJoin('base_datos_siget', 'tipo_luminaria.id', '=', 'base_datos_siget.tipo_luminaria_id')
                ->leftJoin(DB::raw('(SELECT tipo_luminaria_id, COUNT(id) as total_censo_luminarias FROM censo_luminaria GROUP BY tipo_luminaria_id) as censo'), function ($join) {
                    $join->on('tipo_luminaria.id', '=', 'censo.tipo_luminaria_id');
                })
                ->groupBy('tipo_luminaria.nombre', 'censo.total_censo_luminarias')
                ->get();
        }


        $data_censo_siget = [];
        $data_censo_propio = [];
        $data_censo_facturado = [];

        foreach ($tiposLuminarias as $luminarias) {
            $data_censo_siget[] = [
                'name' => $luminarias->tipo,
                'y' => $luminarias->suma_luminarias + 0,
                'drilldown' => $luminarias->tipo
            ];

            $data_censo_propio[] = [
                'name' => $luminarias->tipo,
                'y' => $luminarias->total_censo_luminarias + 0,
                'drilldown' => $luminarias->tipo
            ];

            $data_censo_facturado[] = [
                'name' => $luminarias->tipo,
                'y' =>  $luminarias->total_censo_luminarias - $luminarias->suma_luminarias +  0,
                'drilldown' => $luminarias->tipo
            ];
        }

        return view('control.comparacion_censos.index', compact('data_censo_siget', 'data_censo_propio',
        'data_censo_facturado', 'departamentos', 'nombreDistrito','maxAnio','maxMes','meses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
