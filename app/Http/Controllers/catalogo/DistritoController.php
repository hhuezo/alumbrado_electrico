<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Distrito;
use Illuminate\Http\Request;

class DistritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $distritos = Distrito::get();
        return view('catalogo.distrito.index', compact('distritos'));
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
        $distrito = Distrito::findOrFail($id);
        return view('catalogo.distrito.edit', compact('distrito'));
    }


    public function update(Request $request, $id)
    {
        $distrito = Distrito::findOrFail($id);
        $distrito->extension_territorial = $request->extension_territorial;
        $distrito->poblacion = $request->poblacion;
        $distrito->update();
        alert()->success('El registro ha sido modificado correctamente');
        return back();
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
