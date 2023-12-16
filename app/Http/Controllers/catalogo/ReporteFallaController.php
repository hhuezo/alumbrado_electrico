<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\EstadoReporteFalla;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\TipoFalla;
use App\Models\control\ReporteFalla;
use Exception;
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

        return view('catalogo.reporte_falla.create', compact('departamentos', 'tipos'));
    }

    public function store(Request $request)
    {
        $messages = [
            'tipo_falla_id.required' => 'El tipo de falla es requerido',
            'distrito_id.required' => 'El distrito es requerido',
            'descripcion.required' => 'La descripcion es requerida',
            'fecha.required' => 'La fecha es requerida',
            'latitud.required' => 'La ubicación es requerida',
            'nombre_contacto.required' => 'El nombre es requerido',
        ];

        $request->validate([
            'tipo_falla_id' => 'required',
            'distrito_id' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required',
            'latitud' => 'required',
            'nombre_contacto' => 'required',
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
        alert()->success('El registro ha sido creado correctamente');
        return back();
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $reporte_falla = ReporteFalla::findOrFail($id);
        $departamentos = Departamento::get();
        $distritos = Distrito::where('departamento_id', '=', $reporte_falla->distrito->departamento_id)->get();
        $tipos = TipoFalla::get();
        $estados_reporte = EstadoReporteFalla::get();

        return view('catalogo.reporte_falla.edit', compact('reporte_falla', 'departamentos', 'tipos', 'distritos', 'estados_reporte'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'tipo_falla_id.required' => 'El tipo de falla es requerido',
            'distrito_id.required' => 'El distrito es requerido',
            'descripcion.required' => 'La descripcion es requerida',
            'fecha.required' => 'La fecha es requerida',
            'latitud.required' => 'La ubicación es requerida',
            'nombre_contacto.required' => 'El nombre es requerido',
        ];

        $request->validate([
            'tipo_falla_id' => 'required',
            'distrito_id' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required',
            'latitud' => 'required',
            'nombre_contacto' => 'required',
        ], $messages);

        $reporte_falla = ReporteFalla::findOrFail($id);
        $reporte_falla->fecha = $request->fecha;
        $reporte_falla->distrito_id = $request->distrito_id;
        $reporte_falla->tipo_falla_id = $request->tipo_falla_id;
        $reporte_falla->descripcion = $request->descripcion;
        $reporte_falla->latitud = $request->latitud;
        $reporte_falla->longitud = $request->longitud;
        $reporte_falla->telefono_contacto = $request->telefono_contacto;
        $reporte_falla->nombre_contacto = $request->nombre_contacto;
        $reporte_falla->estado_reporte_id = $request->estado_reporte_id;

        if ($request->file('archivo')) {
            try {
                unlink(public_path("docs/") . $reporte_falla->url_foto);
            } catch (Exception $e) {
                //return $e->getMessage();
            }


            $file = $request->file('archivo');
            $id_file = uniqid();
            $file->move(public_path("docs/"), $id_file . ' ' . $file->getClientOriginalName());
            $reporte_falla->url_foto = $id_file . ' ' . $file->getClientOriginalName();
        }

        $reporte_falla->save();
        alert()->success('El registro ha sido creado correctamente');
        return back();
    }

    public function destroy($id)
    {
        $reporte_falla = ReporteFalla::findOrFail($id);
        $reporte_falla->delete();
        alert()->success('El registro ha sido eliminado correctamente');
        return back();
    }

    public function getDepartamentoId($name)
    {
        $nombreSinDepartamento = str_replace("Departamento de", "", $name);
        $nombreFinal = trim($nombreSinDepartamento);

        $departamentoModel = new Departamento();
        $departamentoId = $departamentoModel->getDepartamentoId($nombreFinal);

        return $departamentoId;
    }

    public function getDistritoId($name)
    {
        $nombreSinDistrito = str_replace("Municipio de", "", $name);
        $nombreFinal = trim($nombreSinDistrito);

        $distritoModel = new Distrito();
        $distritoId = $distritoModel->distritoId($nombreFinal);

        return $distritoId;
    }
}
