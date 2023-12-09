<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Biblioteca;
use App\Models\catalogo\TipoDocumento;
use Exception;
use Illuminate\Http\Request;

class BibliotecaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bibliotecas = Biblioteca::get();
        return view('catalogo.biblioteca.index', compact('bibliotecas'));
    }


    public function create()
    {
        $tipos_documento = TipoDocumento::where('activo', '=', '1')->get();
        return view('catalogo.biblioteca.create', compact('tipos_documento'));
    }

    public function store(Request $request)
    {
        $messages = [
            'tipo_documento_id.required' => 'El tipo de documento es requerido',
            'titulo.required' => 'El titulo es requerido',
            'descripcion.required' => 'La descripcion es requerida',
            'archivo.required' => 'El archivo es requerido',
        ];

        $request->validate([
            'tipo_documento_id' => 'required',
            'titulo' => 'required',
            'descripcion' => 'required',
            'archivo' => 'required',
        ], $messages);

        $biblioteca = new Biblioteca();
        $biblioteca->tipo_documento_id = $request->tipo_documento_id;
        $biblioteca->titulo = $request->titulo;
        $biblioteca->descripcion = $request->descripcion;
        $biblioteca->titulo = $request->titulo;
        if ($request->descargable) {
            $biblioteca->descargable = 1;
        } else {
            $biblioteca->descargable = 0;
        }

        if ($request->file('archivo')) {
            $file = $request->file('archivo');
            $id_file = uniqid();
            $file->move(public_path("docs/"), $id_file . ' ' . $file->getClientOriginalName());
            $biblioteca->archivo = $id_file . ' ' . $file->getClientOriginalName();
        }

        $biblioteca->save();
        alert()->success('El registro ha sido creado correctamente');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $biblioteca = Biblioteca::findOrFail($id);
        $tipos_documento = TipoDocumento::where('activo', '=', '1')->get();
        return view('catalogo.biblioteca.edit', compact('biblioteca', 'tipos_documento'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'tipo_documento_id.required' => 'El tipo de documento es requerido',
            'titulo.required' => 'El titulo es requerido',
            'descripcion.required' => 'La descripcion es requerida',
            'archivo.required' => 'El archivo es requerido',
        ];

        $request->validate([
            'tipo_documento_id' => 'required',
            'titulo' => 'required',
            'descripcion' => 'required',
            //'archivo' => 'required',
        ], $messages);


        $biblioteca = Biblioteca::findOrFail($id);
        $biblioteca->tipo_documento_id = $request->tipo_documento_id;
        $biblioteca->titulo = $request->titulo;
        $biblioteca->descripcion = $request->descripcion;
        $biblioteca->titulo = $request->titulo;
        if ($request->descargable) {
            $biblioteca->descargable = 1;
        } else {
            $biblioteca->descargable = 0;
        }

        if ($request->file('archivo')) {

            try {
                unlink(public_path("docs/") . $biblioteca->archivo);
            } catch (Exception $e) {
                //return $e->getMessage();
            }

            $file = $request->file('archivo');
            $id_file = uniqid();
            $file->move(public_path("docs/"), $id_file . ' ' . $file->getClientOriginalName());
            $biblioteca->archivo = $id_file . ' ' . $file->getClientOriginalName();
        }

        $biblioteca->save();
        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }

    public function destroy($id)
    {
        $biblioteca = Biblioteca::findOrFail($id);
        $biblioteca->activo = false;
        $biblioteca->update();
        alert()->success('El registro ha sido desactivado correctamente');
        return back();
    }

    public function active(Request $request)
    {
        $biblioteca = Biblioteca::findOrFail($request->id);
        $biblioteca->activo = true;
        $biblioteca->update();
        alert()->success('El registro ha sido activado correctamente');
        return back();
    }
}
