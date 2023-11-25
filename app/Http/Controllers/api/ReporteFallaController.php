<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\TipoFalla;
use Illuminate\Http\Request;


class ReporteFallaController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $departamentos = Departamento::get();
        $tipos = TipoFalla::get();

        $response = ["departamentos" => $departamentos, "tipos"=>$tipos];

        return $response;
    }


    public function getDistritos($id)
    {
        $distritos = Distrito::where('departamento_id','=',$id)->get();

        return ["distritos"=>$distritos];
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
