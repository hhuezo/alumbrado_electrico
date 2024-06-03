<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\catalogo\TecnologiaSustituir;
use App\Models\catalogo\TipoLuminaria;
use Exception;
use Illuminate\Http\Request;

class TipoLuminariaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $tipos_luminaria = TipoLuminaria::get();

        return view('catalogo.tipo_luminaria.index', compact('tipos_luminaria'));
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

    public function create_potencia(Request $request)
    {
        $conteo = PotenciaPromedio::where('tipo_luminaria_id', $request->tipo_luminaria_id)->where('potencia', $request->potencia)->count();
        if ($conteo > 0) {
            return back()->withErrors(['msg' => 'Ya existe un registro con ese valor']);
        } else {
            $potencia = new PotenciaPromedio();
            $potencia->tipo_luminaria_id = $request->tipo_luminaria_id;
            $potencia->potencia = $request->potencia;
            $potencia->consumo_promedio = $request->consumo_promedio;
            $potencia->save();

            return back();
        }
    }

    public function create_tecnologia_sustituir($id)
    {
        $PotenciaPromedio = PotenciaPromedio::findOrFail($id);
        $iluminarias = PotenciaPromedio::get();
        $tecnologiasRemplazar= TecnologiaSustituir::where('tecnologia_actual_id',$id)->get();
        $sustituir_id_array =  $tecnologiasRemplazar->pluck('tecnologia_sustituir_id')->toArray();
        $tecnologiasRemplazar = PotenciaPromedio::whereIn('id', $sustituir_id_array)->get();

        //dd($id);
        return view('catalogo.tecnologia_sustituir.edit', compact('PotenciaPromedio','iluminarias','tecnologiasRemplazar'));

    }

    public function store_tecnologia_sustituir(Request $request)
    {
        //dd($request->id,$request->tecnologia_sustituir_id);

        $conteo = TecnologiaSustituir::where('tecnologia_actual_id', $request->id)->where('tecnologia_sustituir_id', $request->tecnologia_sustituir_id)->count();
        //dd($request->id,$request->tecnologia_sustituir_id, $conteo);
        if ($conteo > 0) {
             return back()->withErrors(['msg' => 'Ya existe un registro con ese valor']);
        } else {
            $tecnologiaActual = PotenciaPromedio::find($request->id); // ID de la tecnología actual
            $tecnologiaActual->tecnologiasSustituir()->attach($request->tecnologia_sustituir_id);

            alert()->success('El registro ha agregado correctamente');
            return back();
        }
    }

    public function delete_tecnologia_sustituir(Request $request)
    {
        //dd($request->id,$request->tecnologia_sustituir_id);

        $conteo = TecnologiaSustituir::where('tecnologia_actual_id', $request->id)->where('tecnologia_sustituir_id', $request->tecnologia_sustituir_id_eliminar)->count();
        //dd($request->id,$request->tecnologia_sustituir_id, $conteo);
        if ($conteo == 0) {
             return back()->withErrors(['msg' => 'No existe un registro con ese valor']);
        } else {
            $tecnologiaActual = PotenciaPromedio::find($request->id); // ID de la tecnología actual
            $tecnologiaActual->tecnologiasSustituir()->detach($request->tecnologia_sustituir_id_eliminar);

            alert()->success('El registro ha sido eliminado correctamente');
            return back();
        }
    }

    public function edit($id)
    {
        $tipo_luminaria = TipoLuminaria::findOrFail($id);
        return view('catalogo.tipo_luminaria.edit', compact('tipo_luminaria'));
    }

    public function update(Request $request, $id)
    {
        $tipo_luminaria = TipoLuminaria::findOrFail($id);

        if ($request->hasFile('icono')) {

            try {
                unlink(public_path('img/') . '/' . $tipo_luminaria->icono);
            } catch (Exception $e) {
            }
            $archivo = $request->file('icono');
            $nombreArchivo = uniqid('', true) . '.' . $archivo->getClientOriginalExtension();

            $destino = public_path('img');
            $archivo->move($destino, $nombreArchivo);
            $tipo_luminaria->icono = $nombreArchivo;
        }
        $tipo_luminaria->nombre = $request->nombre;
        $tipo_luminaria->update();

        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }

    public function destroy($id)
    {
        $potencia = PotenciaPromedio::findOrFail($id);
        $potencia->delete();
        alert()->success('El registro ha sido eliminado correctamente');
        return back();
    }
}
