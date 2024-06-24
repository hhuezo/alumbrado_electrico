<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\TipoFalla;
use App\Models\Configuracion;
use App\Models\control\CensoLuminaria;
use App\Models\control\ReporteFalla;
use Illuminate\Http\Request;

class ReporteFallaController extends Controller
{
    public function index()
    {
        $reporte_fallas = ReporteFalla::get();

        return view('catalogo.reporte_falla.index', compact('reporte_fallas'));
    }

    public function create()
    {
        $departamentos = Departamento::get();
        $tipos = TipoFalla::get();
        return view('catalogo.reporte_falla.create', compact('departamentos','tipos'));
    }



    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $reporte_falla = ReporteFalla::findOrFail($id);
        $configuracion = Configuracion::first();

        $censo_luminarias = CensoLuminaria::select('id','latitud','longitud')->groupBy('latitud','longitud')->get();

        $points = $censo_luminarias->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'lat' => (float)$item->latitud,
                'lng' => (float)$item->longitud,
                'title' => 'Punto ' . ($key + 1)
            ];
        });

        return view('catalogo.reporte_falla.show', compact('reporte_falla','configuracion','points'));
    }


    public function registrar_falla(Request $request)
    {
        $reporte_falla = ReporteFalla::findOrFail($request->id);
        $censo = CensoLuminaria::findOrFail($request->censo_id);

        return view('catalogo.reporte_falla.registrar_falla', compact('reporte_falla','censo'));
        dd($reporte_falla);
    }


    public function edit($id)
    {
        //
    }

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
