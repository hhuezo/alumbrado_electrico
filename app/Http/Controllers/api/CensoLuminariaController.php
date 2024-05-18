<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Compania;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\catalogo\TipoFalla;
use App\Models\catalogo\TipoLuminaria;
use App\Models\control\CensoLuminaria;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CensoLuminariaController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
        $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
        $departamentos = Departamento::get();

        $response = ["departamentos" => $departamentos, "tipos" => $tipos];

        return $response;
    }

    public function get_data_create($departamento_id, $distrito_id, $latitude, $longitude,$usuario_id)
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
        if ($distrito_id == 0) {
            $municipios = Municipio::where('departamento_id', $departamento_id)->get();
            $primerMunicipio = Municipio::where('departamento_id', $departamento_id)->first();
            $distritos = Distrito::where('municipio_id', $primerMunicipio->id)->get();
            $companias = Compania::where('activo',1)->get();
        } else {
            $distrito = Distrito::findOrFail($distrito_id);
            $distritos = Distrito::where('municipio_id', $distrito->municipio_id)->get();
            $municipios = Municipio::where('departamento_id', $departamento_id)->get();
            $companias = $distrito->companias;
        }

        $departamentos = Departamento::get();
        $tipos_falla = TipoFalla::where('activo', 1)->get();


        $id_distrito_valido = true;
        $user = User::findOrFail($usuario_id);
        $role_id = $user->user_rol->pluck('id')->toArray();

        if (in_array(3, $role_id) || in_array(4, $role_id)) {
            $distritos_id = $user->distritos->pluck('id')->toArray();
            $municipios = $user->get_municipios($user->id);
            $distritos = Distrito::whereIn('id', $distritos_id)->get();
            $departamentos = $user->get_departamentos($user->id);

            if($distrito_id != null)
            {
                if(!in_array($distrito_id,$distritos_id ))
                {
                    $id_distrito_valido = false;
                }
            }
        }

        $response = [
            "departamentos" => $departamentos, "municipios" => $municipios, "distritos" => $distritos,
            "tipos" => $tipos, "tipos_falla" => $tipos_falla, 'puntosCercanos' => $puntosCercanos,
            'id_distrito_valido'=>$id_distrito_valido,'companias'=>$companias
        ];

        return $response;
    }

    public function get_municipios($id)
    {
        return Municipio::where('departamento_id', '=', $id)->orderBy('nombre')->get();
    }

    public function get_distritos($id)
    {
        return Distrito::where('municipio_id', '=', $id)->get();
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


    public function get_companias($id)
    {
        try{
            $distrito = Distrito::findOrFail($id);
            return $distrito->companias;
        }
        catch(Exception $e)
        {
            return null;
        }

    }

    public function store(Request $request)
    {


        try {
            $codigo = $this->getCodigo($request->distrito_id);
            $censo = new CensoLuminaria();
            $censo->distrito_id = $request->distrito_id;
            $censo->compania_id = $request->compania_id;
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

            $response = ["value" => 1, "mensaje" => "Registro ingresado correctamente", "codigo" => $codigo];
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
        try{
            $censos = DB::table('censo_luminaria')
            ->join('tipo_luminaria as tipo', 'censo_luminaria.tipo_luminaria_id', '=', 'tipo.id')
            ->join('distrito', 'censo_luminaria.distrito_id', '=', 'distrito.id')
            ->join('municipio', 'distrito.municipio_id', '=', 'municipio.id')
            ->join('departamento', 'municipio.departamento_id', '=', 'departamento.id')
            ->select(
                'censo_luminaria.id',
                'censo_luminaria.codigo_luminaria',
                'tipo.nombre as tipo_luminaria',
                'censo_luminaria.potencia_nominal',
                'censo_luminaria.latitud',
                'censo_luminaria.longitud',
                DB::raw("DATE_FORMAT(censo_luminaria.fecha_creacion, '%d/%m/%Y') as fecha"),
                'distrito.nombre as distrito',
                'departamento.nombre as departamento',
                'censo_luminaria.direccion',
                'censo_luminaria.observacion'
            )
            ->where('censo_luminaria.usuario_ingreso', $id)
            ->get();

            if($censos)
            {
                $response = ["value" => 1, "mensaje" => "ok", "censos" => $censos];
            }
            else{
                $response = ["value" => 0, "mensaje" => "error", "censos" => null];
            }


        }
        catch(Exception $e)
        {
            $response = ["value" => 0, "mensaje" => "error", "censos" => null];
        }

            return  $response;

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
