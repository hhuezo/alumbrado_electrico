<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\catalogo\TipoLuminaria;
use App\Models\control\CensoLuminaria;
use Exception;
use Illuminate\Http\Request;

class CensoLuminariaController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
        $departamentos = Departamento::get();

        $response = ["departamentos" => $departamentos, "tipos" => $tipos];

        return $response;
    }

    public function get_data_create($departamento_id,$distrito_id)
    {

        $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
        if($distrito_id == 0)
        {
            $municipios = Municipio::where('departamento_id',$departamento_id)->get();
            $primerMunicipio = Municipio::where('departamento_id', $departamento_id)->first();
            $distritos = Distrito::where('municipio_id',$primerMunicipio->id)->get();
        }
        else{
            $distrito = Distrito::findOrFail($distrito_id);
            $distritos = Distrito::where('municipio_id',$distrito->municipio_id)->get();
            $municipios = Municipio::where('departamento_id',$departamento_id)->get();
        }

        $departamentos = Departamento::get();

        $response = ["departamentos" => $departamentos,"municipios" => $municipios, "distritos" => $distritos, "tipos" => $tipos];

        return $response;
    }



    public function get_potencia_promedio($id)
    {
        $potencia_promedio = PotenciaPromedio::where('tipo_luminaria_id', '=', $id)->select('id', 'potencia')->get();
        if ($potencia_promedio->count() > 0) {
            $response = ["value" => 1, "potencia_promedio" => $potencia_promedio];
        } else {
            $response = ["value" => 0, "potencia_promedio" => []];
        }

        return $response;
    }

    public function get_consumo_mensual($id)
    {
        return PotenciaPromedio::select('consumo_promedio')->findOrFail($id);
    }

    public function store(Request $request)
    {
        try {
            $censo = new CensoLuminaria();
            $censo->distrito_id = $request->distrito_id;
            $censo->tipo_luminaria_id = $request->tipo_luminaria_id;

           // Validar y asignar consumo_mensual
            $censo->consumo_mensual = !empty($request->consumo_mensual) ? $request->consumo_mensual : null;

            $censo->consumo_mensual = $request->consumo_mensual;
            $censo->fecha_ultimo_censo = $request->fecha_ultimo_censo;
            //$censo->usuario_ingreso = auth()->user()->id;
            //$censo->codigo_luminaria = $request->codigo_luminaria;
            $censo->direccion = $request->direccion;
            $censo->latitud = $request->latitud;
            $censo->longitud = $request->longitud;
            $censo->save();

            $response = ["value" => 1, "mensaje" => "Registro ingresado correctamente"];
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            // Loguear el error si es necesario
            \Log::error("Error al guardar el censo: $errorMessage");

            // Agregar el mensaje de error a la respuesta
            $response = ["value" => 0, "mensaje" => $errorMessage];
        }

        return $response;
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
        //
    }

    public function destroy($id)
    {
        //
    }
}
