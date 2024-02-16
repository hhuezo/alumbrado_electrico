<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\control\ValorMensualEnergia;
use Illuminate\Http\Request;

class ValorMensualEnergiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $valor_mesual_energia = ValorMensualEnergia::get();
        $meses = ["01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];

        return view('control.valor_mensual_energia.index', compact('valor_mesual_energia', 'meses'));
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $valor_mesual_energia = ValorMensualEnergia::where('mes', $request->mes)->where('anio', $request->anio)->get();
        if ($valor_mesual_energia->count() > 0) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('error', 'Existen registros para el mes y año especificados.');
            return back()->withErrors($errors);
        } else {
            $valor_mesual_energia = new ValorMensualEnergia();
            $valor_mesual_energia->mes = $request->mes;
            $valor_mesual_energia->anio = $request->anio;
            $valor_mesual_energia->valor = $request->valor;
            $valor_mesual_energia->save();
        }
        alert()->success('El registro ha sido creado correctamente');
        return back();
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $valor_mesual_energia = ValorMensualEnergia::where('mes', $request->mes)->where('anio', $request->anio)->where('id','<>',$id)->get();
        if ($valor_mesual_energia->count() > 0) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('error', 'Existen registros para el mes y año especificados.');
            return back()->withErrors($errors);
        } else {

            $valor_mesual_energia = ValorMensualEnergia::findOrFail($id);
            $valor_mesual_energia->mes = $request->mes;
            $valor_mesual_energia->anio = $request->anio;
            $valor_mesual_energia->valor = $request->valor;
            $valor_mesual_energia->save();
        }
        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }

    public function destroy($id)
    {
        $valor_mesual_energia = ValorMensualEnergia::findOrFail($id);
        $valor_mesual_energia->delete();
        alert()->success('El registro ha sido eliminado correctamente');
        return back();
    }
}
