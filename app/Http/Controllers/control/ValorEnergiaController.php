<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Compania;
use App\Models\control\ValorEnergia;
use App\Models\control\ValorEnergiaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ValorEnergiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $valor_energia = ValorEnergia::get();
        return view('control.valor_mensual_energia.index', compact('valor_energia'));
    }
    public function create()
    {
        $compañias = Compania::where('activo', 1)->get();
        return view('control.valor_mensual_energia.create', compact('compañias'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
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

        DB::commit();
            alert()->success('El registro ha sido actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Ocurrió un error al intentar actualizar el registro.');
        }

        return Redirect::to('control/valor_mensual_energia');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $compañias = Compania::where('activo', 1)->get();
        $valor_energia =  ValorEnergia::findOrFail($id);

        return view('control.valor_mensual_energia.edit', compact('valor_energia', 'compañias'));
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $valor_energia = ValorEnergia::findOrFail($id);
            $valor_energia->fecha_inicio = $request->fecha_inicio;
            $valor_energia->fecha_final = $request->fecha_final;
            $valor_energia->save();

            ValorEnergiaDetalle::where('valor_energia_id', $id)->delete();

            $companias = Compania::where('activo', 1)->get();

            foreach ($companias as $compania) {
                $valor = $request->input("compania_comercializacion_" . $compania->id);
                $detalle = new ValorEnergiaDetalle();
                $detalle->valor_energia_id = $valor_energia->id;
                $detalle->compania_id = $compania->id;
                $detalle->tipo = 1;
                $detalle->valor = $valor;
                $detalle->save();

                $valor = $request->input("compania_energia_" . $compania->id);
                $detalle = new ValorEnergiaDetalle();
                $detalle->valor_energia_id = $valor_energia->id;
                $detalle->compania_id = $compania->id;
                $detalle->tipo = 2;
                $detalle->valor = $valor;
                $detalle->save();

                $valor = $request->input("compania_distribucion_" . $compania->id);
                $detalle = new ValorEnergiaDetalle();
                $detalle->valor_energia_id = $valor_energia->id;
                $detalle->compania_id = $compania->id;
                $detalle->tipo = 3;
                $detalle->valor = $valor;
                $detalle->save();
            }

            DB::commit();
            alert()->success('El registro ha sido actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Ocurrió un error al intentar actualizar el registro.');
        }

        return Redirect::to('control/valor_mensual_energia');
    }




    public function destroy($id)
    {
        DB::beginTransaction(); // Comienza la transacción

        try {
            // Primero, intenta eliminar los detalles asociados
            ValorEnergiaDetalle::where('valor_energia_id', $id)->delete();

            $valor_mesual_energia = ValorEnergia::findOrFail($id);
            $valor_mesual_energia->delete();

            DB::commit();

            alert()->success('El registro ha sido eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack(); // Si ocurre un error, revierte los cambios

            alert()->error('Ocurrió un error al intentar eliminar el registro.');
        }

        return back();
    }
}
