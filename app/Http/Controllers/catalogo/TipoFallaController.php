<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\TipoFalla;
use Illuminate\Http\Request;

class TipoFallaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tipos_falla = TipoFalla::where('activo',1)->get();
        return view('catalogo.tipo_falla.index', compact('tipos_falla'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catalogo.tipo_falla.create');
    }


    public function store(Request $request)
    {
        $tipo_falla = new TipoFalla();
        $tipo_falla->nombre = $request->nombre;
        $tipo_falla->activo = 1;
        $tipo_falla->save();
        alert()->success('El registro ha sido creado correctamente');
        return back();
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


    public function edit($id)
    {
        $tipo_falla = TipoFalla::findOrFail($id);
        return view('catalogo.tipo_falla.edit',compact('tipo_falla'));

    }

    public function update(Request $request, $id)
    {
        $tipo_falla = TipoFalla::findOrFail($id);
        $tipo_falla->nombre = $request->nombre;
        $tipo_falla->update();
        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }

    public function destroy($id)
    {
        $tipo_falla = TipoFalla::findOrFail($id);
        $tipo_falla->activo = 0;
        $tipo_falla->update();
        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }
}
