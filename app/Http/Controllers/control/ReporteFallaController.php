<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\TipoFalla;
use App\Models\control\ReporteFalla;
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

        return view('catalogo.reporte_falla.create', compact('departamentos','tipos'));
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        //
    }


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
