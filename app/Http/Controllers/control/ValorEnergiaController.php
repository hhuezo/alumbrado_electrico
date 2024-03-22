<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Compania;
use App\Models\control\ValorEnergia;
use App\Models\control\ValorEnergiaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ValorEnergiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $valor_mesual_energia = ValorEnergia::get();
        $meses = ["01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];

        return view('control.valor_mensual_energia.index', compact('valor_mesual_energia', 'meses'));
    }
    public function create()
    {
        $compañias = Compania::where('activo', 1)->get();
        return view('control.valor_mensual_energia.create', compact('compañias'));
    }

    public function store(Request $request)
    {

        $valor_energia = new ValorEnergia();
        //$valor_energia->mes = $request->mes;
        $valor_energia->fecha_inicio = $request->fecha_inicio;
        $valor_energia->fecha_final = $request->fecha_final;
        $valor_energia->save();

        $compañias = Compania::where('activo', 1)->get();

        foreach ($compañias as $compañia) {
            $valor = $request->input("compania_comercializacion_" . $compañia->id);
            //1 Cargo de comercialización
            $detalle = new ValorEnergiaDetalle();
            $detalle->valor_energia_id = $valor_energia->id;
            $detalle->compania_id = $compañia->id;
            $detalle->tipo = 1;
            $detalle->valor = $valor;
            $detalle->save();


            $valor = $request->input("compania_energia_" . $compañia->id);
            //1 Cargo de comercialización
            $detalle = new ValorEnergiaDetalle();
            $detalle->valor_energia_id = $valor_energia->id;
            $detalle->compania_id = $compañia->id;
            $detalle->tipo = 2;
            $detalle->valor = $valor;
            $detalle->save();


            $valor = $request->input("compania_distribucion_" . $compañia->id);
            //1 Cargo de comercialización
            $detalle = new ValorEnergiaDetalle();
            $detalle->valor_energia_id = $valor_energia->id;
            $detalle->compania_id = $compañia->id;
            $detalle->tipo = 3;
            $detalle->valor = $valor;
            $detalle->save();
        }

        alert()->success('El registro ha sido creado correctamente');
        return Redirect::to('control/valor_mensual_energia');

        /*$valor_mesual_energia = ValorEnergia::where('mes', $request->mes)->where('anio', $request->anio)->get();
        if ($valor_mesual_energia->count() > 0) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('error', 'Existen registros para el mes y año especificados.');
            return back()->withErrors($errors);
        } else {
            $valor_mesual_energia = new ValorEnergia();
            $valor_mesual_energia->mes = $request->mes;
            $valor_mesual_energia->anio = $request->anio;
            $valor_mesual_energia->valor = $request->valor;
            $valor_mesual_energia->save();
        }
        alert()->success('El registro ha sido creado correctamente');
        return back();*/
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
        $valor_mesual_energia = ValorEnergia::where('mes', $request->mes)->where('anio', $request->anio)->where('id', '<>', $id)->get();
        if ($valor_mesual_energia->count() > 0) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('error', 'Existen registros para el mes y año especificados.');
            return back()->withErrors($errors);
        } else {

            $valor_mesual_energia = ValorEnergia::findOrFail($id);
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
        $valor_mesual_energia = ValorEnergia::findOrFail($id);
        $valor_mesual_energia->delete();
        alert()->success('El registro ha sido eliminado correctamente');
        return back();
    }
}
