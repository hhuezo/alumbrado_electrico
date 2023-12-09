<?php

namespace App\Http\Controllers\publico;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\TipoFalla;
use App\Models\Configuracion;
use App\Models\control\ReporteFalla;
use Illuminate\Http\Request;

class ReporteFallaPublicoController extends Controller
{

    public function index()
    {
        $departamentos = Departamento::get();
        $tipos = TipoFalla::get();
        $configuracion = Configuracion::first();

        return view('publico.reporte_falla', compact('departamentos', 'tipos','configuracion'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $messages = [
            'tipo_falla_id.required' => 'El tipo de falla es requerido',
            'distrito_id.required' => 'El distrito es requerido',
            'descripcion.required' => 'La descripción es requerida',
            'fecha.required' => 'La fecha es requerida',
            'latitud.required' => 'La ubicación es requerida',
            'nombre_contacto.required' => 'El nombre es requerido',
            'telefono_contacto.required' => 'El teléfono es requerido',
            'telefono_contacto.regex' => 'El formato del teléfono es incorrecto.',
        ];

        $request->validate([
            'tipo_falla_id' => 'required',
            'distrito_id' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required',
            'latitud' => 'required',
            'nombre_contacto' => 'required',
            'telefono_contacto' => 'required|regex:/^\d{4}-\d{4}$/',
        ], $messages);

        $reporte_falla = new ReporteFalla();
        $reporte_falla->fecha = $request->fecha;
        $reporte_falla->distrito_id = $request->distrito_id;
        $reporte_falla->tipo_falla_id = $request->tipo_falla_id;
        $reporte_falla->descripcion = $request->descripcion;
        $reporte_falla->latitud = $request->latitud;
        $reporte_falla->longitud = $request->longitud;
        $reporte_falla->telefono_contacto = $request->telefono_contacto;
        $reporte_falla->nombre_contacto = $request->nombre_contacto;
        $reporte_falla->estado_reporte_id = 1;

        if ($request->file('archivo')) {
            $file = $request->file('archivo');
            $id_file = uniqid();
            $file->move(public_path("docs/"), $id_file . ' ' . $file->getClientOriginalName());
            $reporte_falla->url_foto = $id_file . ' ' . $file->getClientOriginalName();
        }

        $reporte_falla->save();
        return view('publico.reporte_falla_mensaje');
        //return back();
    }


    public function get_distritos($id)
    {
        return Distrito::where('departamento_id', '=', $id)->get();
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
