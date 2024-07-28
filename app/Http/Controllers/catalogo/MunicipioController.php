<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $municipios = Municipio::get();
        return view('catalogo.municipio.index', compact('municipios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $municipio = Municipio::findOrFail($id);
        /*$companias = Compania::where('activo', 1)->get();
        foreach ($companias as $compania) {
            $registro = $compania->distritos->where('id', $id)->first();
           if ($registro) {
                $compania->in_distrito = 1;
            } else {
                $compania->in_distrito = 0;
            }
        }*/

        return view('catalogo.municipio.edit', compact('municipio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $municipio = Municipio::findOrFail($id);
        if ($request->convenio != null) {
            $municipio->convenio = 1;
        } else {
            $municipio->convenio = 0;
        }
        $municipio->nombre_responsable = $request->nombre_responsable;
        $municipio->correo_responsable = $request->correo_responsable;
        $municipio->telefono_responsable = $request->telefono_responsable;
        $municipio->direccion_responsable = $request->direccion_responsable;
        $municipio->puesto_responsable = $request->puesto_responsable;
        $municipio->update();
        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }

    public function convenioFirmado(Request $request){

        Municipio::findOrFail($request->MunicipioId)->update(['convenio' => $request->convenio]);

        return response()->json(['exito' => 1]);
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
