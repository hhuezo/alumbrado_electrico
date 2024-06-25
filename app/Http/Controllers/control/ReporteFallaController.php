<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\TipoFalla;
use App\Models\Configuracion;
use App\Models\control\CensoLuminaria;
use App\Models\control\ReporteFalla;
use App\Models\control\ReporteFallaSeguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        return view('catalogo.reporte_falla.create', compact('departamentos', 'tipos'));
    }



    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $reporte_falla = ReporteFalla::findOrFail($id);
          if($reporte_falla->censo_luminaria_id != null)
        {

            return Redirect::to('reporte_falla/registrar_falla?id='.$reporte_falla->id.'&censo_id='.$reporte_falla->censo_luminaria_id);
        }
        $configuracion = Configuracion::first();

        $censo_luminarias = CensoLuminaria::select('id', 'latitud', 'longitud')->groupBy('latitud', 'longitud')->get();

        $points = $censo_luminarias->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'lat' => (float)$item->latitud,
                'lng' => (float)$item->longitud,
                'title' => 'Punto ' . ($key + 1)
            ];
        });

        return view('catalogo.reporte_falla.show', compact('reporte_falla', 'configuracion', 'points'));
    }


    public function registrar_falla(Request $request)
    {
        $reporte_falla = ReporteFalla::findOrFail($request->id);
        $censo = CensoLuminaria::findOrFail($request->censo_id);
        $tipos_falla = TipoFalla::where('activo', 1)->get();
        return view('catalogo.reporte_falla.registrar_falla', compact('reporte_falla', 'censo', 'tipos_falla'));
    }

    public function store_falla(Request $request)
    {
        // Define the validation rules
        $rules = [
            'censo_id' => 'required|integer',
            'fecha' => 'required',
            'reporte_falla_id' => 'required|integer',
            'observacion' => 'required|string',
        ];

        // Add a custom validation rule for tipo_falla_id
        if ($request->condicion_lampara == null) {
            $rules['tipo_falla_id'] = 'required|integer';
        }

        // Define custom validation messages
        $messages = [
            'censo_id.required' => 'El campo censo_id es obligatorio.',
            'censo_id.integer' => 'El campo censo_id debe ser un número entero.',
            'reporte_falla_id.required' => 'El campo reporte_falla_id es obligatorio.',
            'reporte_falla_id.integer' => 'El campo reporte_falla_id debe ser un número entero.',
            'observacion.required' => 'El campo observación es obligatorio.',
            'observacion.string' => 'El campo observación debe ser un texto.',
            'tipo_falla_id.required' => 'El tipo de falla es obligatorio cuando la lámpara no está en buenas condiciones.',
            'tipo_falla_id.integer' => 'El falla debe ser un número entero.',
            'fecha.required' => 'La fecha es obligatoria.',
        ];

        // Validate the request data with custom messages
        $validatedData = $request->validate($rules, $messages);

        // Create a new instance of ReporteFallaSeguimiento
        $reporteFallaSeguimiento = new ReporteFallaSeguimiento();
        $reporteFallaSeguimiento->reporte_falla_id = $request->reporte_falla_id;
        $reporteFallaSeguimiento->censo_luminaria_id = $request->censo_id;
        $reporteFallaSeguimiento->fecha = $request->fecha;
        $reporteFallaSeguimiento->usuario_creacion = auth()->user()->id;
        if ($request->condicion_lampara == null) {
            $reporteFallaSeguimiento->condicion_lampara = 0;
        } else {
            $reporteFallaSeguimiento->condicion_lampara = 1;
        }
        $reporteFallaSeguimiento->observacion = $request->observacion;


        if (isset($request->tipo_falla_id)) {
            $reporteFallaSeguimiento->tipo_falla_id = $request->tipo_falla_id;
        }
        $reporteFallaSeguimiento->estado_reporte_falla_id = 2;

        // Save the new record to the database
        $reporteFallaSeguimiento->save();

        $reporte_falla = ReporteFalla::findOrFail($request->reporte_falla_id);
        $reporte_falla->estado_reporte_id = 2;
        $reporte_falla->censo_luminaria_id = $request->censo_id;
        $reporte_falla->save();

        $censo = CensoLuminaria::findOrFail($request->censo_id);
        if ($request->condicion_lampara == null) {
            $censo->condicion_lampara = 0;
            $censo->tipo_falla_id = $request->tipo_falla_id;
        } else {
            $censo->condicion_lampara = 1;
            $censo->tipo_falla_id =  null;
        }
        $censo->save();

        alert()->success('El registro ha sido creado correctamente');


        return back();
    }

    public function finalizar_falla(Request $request)
    {

        $reporteFallaSeguimiento = new ReporteFallaSeguimiento();
        $reporteFallaSeguimiento->reporte_falla_id = $request->reporte_falla_id;
        $reporteFallaSeguimiento->censo_luminaria_id = $request->censo_id;
        $reporteFallaSeguimiento->fecha = $request->fecha;
        $reporteFallaSeguimiento->condicion_lampara = 1;
        $reporteFallaSeguimiento->observacion = $request->observacion;
        $reporteFallaSeguimiento->estado_reporte_falla_id = 3;
        $reporteFallaSeguimiento->usuario_creacion = auth()->user()->id;

        // Save the new record to the database
        $reporteFallaSeguimiento->save();

        $reporte_falla = ReporteFalla::findOrFail($request->reporte_falla_id);
        $reporte_falla->estado_reporte_id = 3;
        $reporte_falla->save();

        $censo = CensoLuminaria::findOrFail($request->censo_id);
        $censo->condicion_lampara = 1;
        $censo->tipo_falla_id =  null;

        $censo->save();

        alert()->success('El registro ha sido creado correctamente');


        return back();
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
