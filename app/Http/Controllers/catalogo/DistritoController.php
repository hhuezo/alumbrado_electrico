<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Compania;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\User;
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
        $distrito = Distrito::findOrFail($request->distrito_id);
        $compania = $distrito->companias->where('id', $request->compania_id)->first();

        if ($compania) {
            $distrito->companias()->detach($request->compania_id);
        } else {
            $distrito->companias()->attach($request->compania_id);
        }
        return $compania;
    }

    public function get_municipios($id)
    {
        $user = User::findOrFail(auth()->user()->id);

        if ($user->hasAnyRole(['administrador', 'Tecnico DGEHM'])) {
            return Municipio::where('departamento_id', $id)->get();
        }
        else{
            $distritos_id = $user->distritos->pluck('municipio_id')->toArray();
            $distritos_id_uniques = array_unique($distritos_id);
            $municipios =  Municipio::whereIn('id', $distritos_id_uniques)->get();
            return $municipios;
        }



    }

    public function get_distritos($id)
    {
        $user = User::findOrFail(auth()->user()->id);

        if ($user->hasAnyRole(['administrador', 'Tecnico DGEHM'])) {
            return Distrito::where('municipio_id', $id)->get();
        }
        else{
            $distritos = $user->distritos;
            return $distritos;
        }

    }

    public function get_option($id)
    {
        $distrito = Distrito::findOrFail($id);
        return response()->json($distrito);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $distrito = Distrito::findOrFail($id);
        $companias = Compania::where('activo', 1)->get();
        foreach ($companias as $compania) {
            $registro = $compania->distritos->where('id', $id)->first();
            if ($registro) {
                $compania->in_distrito = 1;
            } else {
                $compania->in_distrito = 0;
            }
        }

        return view('catalogo.distrito.edit', compact('distrito', 'companias'));
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
