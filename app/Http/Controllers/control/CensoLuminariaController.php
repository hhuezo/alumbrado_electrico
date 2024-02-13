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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

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
            $municipios = null;
            $municipio_id = null;

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
                        $municipios =  Municipio::where('departamento_id', $id_departamento)->get();

                        if ($api_municipio) {
                            $distrito = Distrito::select('distrito.id', 'distrito.nombre', 'distrito.municipio_id')
                            ->join('municipio', 'municipio.id', '=', 'distrito.municipio_id')->where('municipio.departamento_id', $id_departamento)
                            ->where('distrito.nombre', $api_municipio)->first();

                            if ($distrito) {
                                $distritos = Distrito::where('municipio_id', $distrito->municipio_id)->get();

                                $id_distrito = $distrito->id;
                                $municipio_id = $distrito->municipio_id;
                            }
                        }
                        else{

                            $municipio_id = $municipios::select('id')->first();
                            dd($municipio_id    );
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
            return view('control.censo_luminaria.create', compact('tipos', 'departamentos', 'distritos', 'municipios', 'configuracion', 'latitude', 'longitude', 'id_departamento', 'id_distrito', 'municipio_id', 'direccion'));
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
        return Distrito::where('municipio_id', '=', $id)->get();
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
        $codigo = $this->getCodigo($request->distrito_id);
        $censo = new CensoLuminaria();
        $censo->tipo_luminaria_id = $request->tipo_luminaria_id;
        $censo->potencia_nominal = $request->potencia_nominal;
        $censo->consumo_mensual = $request->consumo_mensual;
        $censo->fecha_ultimo_censo = $request->fecha_ultimo_censo;
        $censo->distrito_id = $request->distrito_id;
        $censo->usuario_ingreso = auth()->user()->id;
        $censo->direccion = $request->direccion;
        $censo->codigo_luminaria = $codigo;
        $censo->latitud = $request->latitud;
        $censo->longitud = $request->longitud;
        $censo->observacion = $request->observacion;
        $censo->save();


        $url_en_qr =  url('/') . "/control/censo_luminaria/" . $codigo;

        QrCode::format('png')->size(200)->generate($url_en_qr . '0', public_path('qr/' . $codigo . '.png'));
        $file = public_path('qr/' . $codigo . '.png');

        alert()->success('El registro ha sido creado correctamente');



        $folderPath = public_path('qr'); // Ruta a la carpeta public/qr
        $files = File::allFiles($folderPath);
        $days = 1; // Número de días para considerar un archivo como antiguo
        $timeThreshold = now()->subDays($days)->getTimestamp(); // Fecha límite para eliminar

        foreach ($files as $file) {
            if (filemtime($file) < $timeThreshold) {
                unlink($file); // Elimina el archivo
                $this->info("Archivo eliminado: {$file}");
            }
        }



        return view('control.censo_luminaria.resumen', compact('censo'));
        //return redirect('control/censo_luminaria/');
    }


    public function getCodigo($id)
    {
        $distrito = Distrito::findOrFail($id);
        $codigo = "";
        $max_codigo = CensoLuminaria::where('distrito_id', $id)->max('codigo_luminaria');

        if (!$max_codigo) {
            $codigo = $distrito->codigo .'00001';
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
        $censo = CensoLuminaria::findOrFail($id);
        $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
        $departamentos = Departamento::get();
        $distritos = Distrito::where('departamento_id', '=', $censo->distrito->deaprtamento_id)->get();

        $potencias_promedio = PotenciaPromedio::where('tipo_luminaria_id', '=', $censo->tipo_luminaria_id)->get();

        return view('control.censo_luminaria.edit', compact('censo', 'tipos', 'departamentos', 'distritos', 'potencias_promedio'));
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
