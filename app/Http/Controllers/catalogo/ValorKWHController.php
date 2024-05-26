<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class ValorKWHController extends Controller
{
    public function index()
    {
        $configuracion = Configuracion::get();
        return view('catalogo.valorkwh.index', compact('configuracion'));
    }

    public function edit($id)
    {
        $configuracion = Configuracion::findOrFail($id);
        return view('catalogo.valorkwh.edit',compact('configuracion'));

    }

    public function update(Request $request, $id)
    {
        $configuracion = Configuracion::findOrFail($id);
        $configuracion->valor_kwh = $request->valor_kwh;
        $configuracion->update();
        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }

}
