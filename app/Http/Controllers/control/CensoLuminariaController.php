<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\catalogo\TipoLuminaria;
use App\Models\Configuracion;
use App\Models\control\CensoLuminaria;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CensoLuminariaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $censo_luminarias = CensoLuminaria::get();
        return view('control.censo_luminaria.index', compact('censo_luminarias'));
    }


    public function show_map()
    {
        $configuracion = Configuracion::first();
        return view('control.censo_luminaria.map', compact('configuracion'));
    }

    public function create(Request $request)
    {
        if ($request->latitude && $request->longitude) {
            $latitude = $request->latitude;
            $longitude = $request->longitude;


            $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$latitude}&lon={$longitude}";

            $client = new Client();
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            $id_departamento = null;
            $id_distrito = null;
            $distritos = null;
            $direccion = null;

            if (isset($data['address'])) {
                $api_departamento = $data['address']['state'];
                $api_departamento = str_replace("Departamento de ", "", $api_departamento);
                $api_municipio = $data['address']['city'] ?? $data['address']['town'] ?? $data['address']['village'] ?? $data['address']['county'];
                $api_municipio = str_replace("Municipio de ", "", $api_municipio);
                $direccion = $data['display_name'];

                if ($api_departamento) {
                    $departamento = Departamento::where('nombre', $api_departamento)->first();
                    if ($departamento) {
                        $id_departamento = $departamento->id;
                        if ($api_municipio) {
                            $distrito = Distrito::where('departamento_id', $id_departamento)->where('nombre', $api_municipio)->first();
                            $distritos = Distrito::where('departamento_id', $id_departamento)->get();
                            if ($distrito) {
                                $id_distrito = $distrito->id;
                            }
                        }
                    }
                }
            } else {
                // Manejar la situación donde no se pudo obtener la información de ubicación
                \Log::error("No se pudo obtener la información de ubicación.");
            }


            $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
            $departamentos = Departamento::get();
            $configuracion = Configuracion::first();
            return view('control.censo_luminaria.create', compact('tipos', 'departamentos', 'distritos','configuracion', 'latitude', 'longitude', 'id_departamento', 'id_distrito','direccion'));
        } else {
            alert()->error('la ubicacion es incorrecta');
            return back();
        }
    }

    public function get_municipios($id)
    {
        return Municipio::where('departamento_id', '=', $id)->orderBy('nombre')->get();
    }

    public function get_distritos($id)
    {
        return Distrito::where('departamento_id', '=', $id)->get();
    }

    public function get_potencia_promedio($id)
    {
        return PotenciaPromedio::where('tipo_luminaria_id', '=', $id)->get();
    }

    public function get_consumo_mensual($id)
    {
        return PotenciaPromedio::findOrFail($id);
    }



    public function store(Request $request)
    {
        $censo = new CensoLuminaria();
        $censo->tipo_luminaria_id = $request->tipo_luminaria_id;
        $censo->potencia_nominal = $request->potencia_nominal;
        $censo->consumo_mensual = $request->consumo_mensual;
        $censo->fecha_ultimo_censo = $request->fecha_ultimo_censo;
        $censo->distrito_id = $request->distrito_id;
        $censo->usuario_ingreso = auth()->user()->id;
        $censo->direccion = $request->direccion;
        //$censo->decidad_luminicia = $request->decidad_luminicia;
        $censo->latitud = $request->latitud;
        $censo->longitud = $request->longitud;
        $censo->save();
        alert()->success('El registro ha sido creado correctamente');
        return redirect('control/censo_luminaria/');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $censo = CensoLuminaria::findOrFail($id);
        $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
        $departamentos = Departamento::get();
        $distritos = Distrito::where('departamento_id', '=', $censo->distrito->deaprtamento_id)->get();

        $potencias_promedio = PotenciaPromedio::where('tipo_luminaria_id', '=', $censo->tipo_luminaria_id)->get();

        return view('control.censo_luminaria.edit', compact('censo', 'tipos', 'departamentos', 'distritos', 'potencias_promedio'));
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
