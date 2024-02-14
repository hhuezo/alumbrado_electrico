<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\TipoLuminaria;
use Exception;
use Illuminate\Http\Request;

class TipoLuminariaController extends Controller
{

    public function index()
    {
        $tipos_luminaria = TipoLuminaria::get();

        return view('catalogo.tipo_luminaria.index', compact('tipos_luminaria'));
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
        $tipo_luminaria = TipoLuminaria::findOrFail($id);
        return view('catalogo.tipo_luminaria.edit', compact('tipo_luminaria'));
    }

    public function update(Request $request, $id)
    {
        $tipo_luminaria = TipoLuminaria::findOrFail($id);

        if ($request->hasFile('icono')) {

            try{
                unlink(public_path('img/').'/'. $tipo_luminaria->icono);
            }
            catch(Exception $e){

            }
            $archivo = $request->file('icono');
            $nombreArchivo = uniqid('', true) . '.' . $archivo->getClientOriginalExtension();

            $destino = public_path('img');
            $archivo->move($destino, $nombreArchivo);
            $tipo_luminaria->icono = $nombreArchivo;
        }
        $tipo_luminaria->nombre = $request->nombre;
        $tipo_luminaria->update();

        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }

    public function destroy($id)
    {
        //
    }
}
