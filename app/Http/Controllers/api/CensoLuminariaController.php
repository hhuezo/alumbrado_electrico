<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\catalogo\TipoFalla;
use App\Models\catalogo\TipoLuminaria;
use App\Models\control\CensoLuminaria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function get_data_create($departamento_id,$distrito_id,$latitude,$longitude)
    {

        //verificar si existe algun punto cerca
        $radio = 10; //radio en metros a la redonda
        // Conversión de metros a grados decimales
        $radioEnGrados = $radio / 111.319; // Aproximadamente 1 grado = 111.319 km en el ecuador

        $puntosCercanos = DB::table('censo_luminaria')->select('*')
            // Haversine Formula
            ->selectRaw("(6371 * acos(cos(radians(?))
            * cos(radians(latitud))
            * cos(radians(longitud) - radians(?))
            + sin(radians(?))
            * sin(radians(latitud)))) AS distancia", [$latitude, $longitude, $latitude])
            ->havingRaw("distancia < ?", [$radioEnGrados])
            ->count();

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
        $tipos_falla = TipoFalla::where('activo',1)->get();

        $response = ["departamentos" => $departamentos,"municipios" => $municipios, "distritos" => $distritos,
        "tipos" => $tipos, "tipos_falla" => $tipos_falla,'puntosCercanos'=>$puntosCercanos];

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
            $codigo = $this->getCodigo($request->distrito_id);
            $censo = new CensoLuminaria();
            $censo->distrito_id = $request->distrito_id;
            $censo->tipo_luminaria_id = $request->tipo_luminaria_id;
            $censo->codigo_luminaria = $codigo;

           // Validar y asignar consumo_mensual
            $censo->consumo_mensual = !empty($request->consumo_mensual) ? $request->consumo_mensual : null;

            $censo->tipo_falla_id = !empty($request->tipo_falla) ? $request->tipo_falla : null;


            $censo->usuario_creacion = $request->usuario;
            //$censo->codigo_luminaria = $request->codigo_luminaria;
            $censo->direccion = $request->direccion;
            $censo->latitud = $request->latitud;
            $censo->longitud = $request->longitud;
            $censo->observacion = $request->observacion;
            $censo->condicion_lampara = $request->condicion_lampara;
            $censo->save();

            $response = ["value" => 1, "mensaje" => "Registro ingresado correctamente", "codigo"=>$codigo];
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            // Loguear el error si es necesario
            \Log::error("Error al guardar el censo: $errorMessage");

            // Agregar el mensaje de error a la respuesta
            $response = ["value" => 0, "mensaje" => $errorMessage];
        }

        return $response;
    }

    public function getCodigo($id)
    {
        $distrito = Distrito::findOrFail($id);
        $codigo = "";
        $max_codigo = CensoLuminaria::where('distrito_id', $id)->max('codigo_luminaria');

        if (!$max_codigo) {
            $codigo = $distrito->codigo . '00001';
        } else {
            $max_codigo++;

            $longitud_deseada = 5; // numero de caracteres
            // Convertir el número a una cadena y luego aplicar str_pad
            $numero_formateado = str_pad((string)$max_codigo, $longitud_deseada, '0', STR_PAD_LEFT);

            $codigo = $numero_formateado;
        }

        return  $codigo;
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
