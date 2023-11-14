<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\catalogo\TipoLuminaria;
use App\Models\control\CensoLuminaria;
use Illuminate\Http\Request;

class CensoLuminariaController extends Controller
{

    public function __construct()
    {
          $this->middleware('auth');
    }

    public function index()
    {
        $censo_luminarias = CensoLuminaria::get();
        return view('control.censo_luminaria.index', compact('censo_luminarias'));
    }


    public function create()
    {
        $tipos = TipoLuminaria::where('Activo','=',1)->get();
        $departamentos = Departamento::get();
        return view('control.censo_luminaria.create', compact('tipos','departamentos'));
    }

    public function get_municipios($id)
    {
        return Municipio::where('departamento_id','=',$id)->get();
    }

    public function get_distritos($id)
    {
        return Distrito::where('municipio_id','=',$id)->get();
    }

    public function get_potencia_promedio($id)
    {
        return PotenciaPromedio::where('tipo_luminaria_id','=',$id)->get();
    }


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
        //
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
