<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComparacionCensosController extends Controller
{

    public function index()
    {
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
        //->whereIn('base_datos_siget.municipio_id', $id_distrito)
        ->groupBy('tipo_luminaria.nombre', 'censo.total_censo_luminarias')
        ->get();

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


        return view('control.comparacion_censos.index', compact( 'data_censo_siget',        'data_censo_propio',        'data_censo_facturado'));
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
