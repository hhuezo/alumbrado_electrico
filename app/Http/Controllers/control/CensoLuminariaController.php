<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Compania;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\catalogo\TipoFalla;
use App\Models\catalogo\TipoLuminaria;
use App\Models\Configuracion;
use App\Models\control\CensoLuminaria;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
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
        $user = User::findOrFail(auth()->user()->id);
        $role_id = $user->user_rol->pluck('id')->toArray();

        if (in_array(1, $role_id) || in_array(2, $role_id)) {
            $censo_luminarias = CensoLuminaria::groupBy('codigo_luminaria')->orderby('id', 'desc')->get();
        } else {
            $distritos_id = $user->distritos->pluck('id')->toArray();

            $censo_luminarias = CensoLuminaria::whereIn('distrito_id', $distritos_id)->groupBy('codigo_luminaria')->orderby('id', 'desc')->get();
        }

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




            $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$latitude}&lon={$longitude}";

            $client = new Client();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'User-Agent' => 'MyLaravelApp/1.0 (contact@myapp.com)'
                ]
            ]);
            $data = json_decode($response->getBody(), true);

            $id_departamento = null;
            $id_distrito = null;
            $distritos = null;
            $direccion = null;
            $municipios = null;
            $municipio_id = null;
            $id_distrito_valido = 1;

            $companias = Compania::where('activo', 1)->get();

            if (isset($data['address'])) {

                $api_departamento = $data['address']['state'];
                $api_departamento = str_replace("Departamento de ", "", $api_departamento);
                $departamento = Departamento::where('nombre', $api_departamento)->first();
                if ($departamento) {
                    $id_departamento = $departamento->id;
                }

                if (isset($data['address']['state_district'])) {
                    $api_municipio = $data['address']['state_district'];
                    $municipio = Municipio::where('nombre', $api_municipio)->first();
                    if ($municipio) {
                        $municipio_id = $municipio->id;
                    }
                }


                $api_distrito = $data['address']['city'] ?? $data['address']['town'] ?? $data['address']['village'] ?? ($data['address']['county'] ?? null);
                $distrito_nombre = str_replace("Distrito de ", "", $api_distrito);
                $distrito = Distrito::where('nombre', $distrito_nombre)->first();
                if ($distrito) {
                    $id_distrito = $distrito->id;
                }

                $direccion = $data['display_name'];
            } else {
                // Manejar la situación donde no se pudo obtener la información de ubicación
                \Log::error("No se pudo obtener la información de ubicación.");
            }


            $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
            $departamentos = Departamento::get();
            if ($id_departamento != null) {
                $municipios = Municipio::where('departamento_id', $id_departamento)->get();
            }

            if ($municipio_id != null) {
                $distritos = Distrito::where('municipio_id', $municipio_id)->get();
            }
            $configuracion = Configuracion::first();
            $tipos_falla = TipoFalla::where('activo', '1')->get();

            $user = User::findOrFail(auth()->user()->id);
            $role_id = $user->user_rol->pluck('id')->toArray();

            if (in_array(3, $role_id) || in_array(4, $role_id)) {
                $distritos_id = $user->distritos->pluck('id')->toArray();
                $municipios = $user->get_municipios($user->id);
                $distritos = Distrito::whereIn('id', $distritos_id)->get();
                $departamentos = $user->get_departamentos($user->id);

                if ($id_distrito != null) {
                    if (!in_array($id_distrito, $distritos_id)) {
                        $id_distrito_valido = false;
                    }
                }
            }



            return view('control.censo_luminaria.create', compact(
                'tipos',
                'departamentos',
                'distritos',
                'municipios',
                'configuracion',
                'latitude',
                'longitude',
                'id_departamento',
                'id_distrito',
                'municipio_id',
                'direccion',
                'puntosCercanos',
                'tipos_falla',
                'id_distrito_valido',
                'companias'
            ));
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


    public function get_companias($id)
    {
        try {
            $distrito = Distrito::findOrFail($id);
            return $distrito->companias;
        } catch (Exception $e) {
            return null;
        }
    }




    public function store(Request $request)
    {
        $codigo = $this->getCodigo($request->distrito_id);
        $censo = new CensoLuminaria();
        $censo->tipo_luminaria_id = $request->tipo_luminaria_id;
        if ($request->potencia_nominal != null) {
            $censo->potencia_nominal = $request->potencia_nominal;
        } elseif ($request->potencia_promedio != null) {
            $censo->potencia_nominal = PotenciaPromedio::findOrFail($request->potencia_promedio)->potencia;
        } else {
            $censo->potencia_nominal = $request->potencia_nominal_led_val;

            $existingPotencia = PotenciaPromedio::where('tipo_luminaria_id', $request->tipo_luminaria_id)
                ->where('potencia', $request->potencia_nominal_led_val)
                ->first();

            if (!$existingPotencia) {
                $potencia = new PotenciaPromedio();
                $potencia->tipo_luminaria_id = $request->tipo_luminaria_id;
                $potencia->potencia = $request->potencia_nominal_led_val;
                $potencia->consumo_promedio = $request->consumo_mensual;
                $potencia->save();
            }
        }
        $censo->consumo_mensual = $request->consumo_mensual;
        $censo->distrito_id = $request->distrito_id;
        $censo->usuario_ingreso = auth()->user()->id;
        $censo->direccion = $request->direccion;
        $censo->codigo_luminaria = $codigo;
        $censo->latitud = $request->latitud;
        $censo->longitud = $request->longitud;
        $censo->observacion = $request->observacion;
        if ($request->condicion_lampara != null) {
            $censo->condicion_lampara = 1;
        } else {
            $censo->condicion_lampara = 0;
        }
        $censo->tipo_falla_id = $request->tipo_falla_id;
        $censo->compania_id = $request->compania_id;
        $censo->save();


        $url_en_qr =  $codigo;

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
                //$this->info("Archivo eliminado: {$file}");
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
        $censo = CensoLuminaria::findOrFail($id);
        $codigo = $censo->codigo_luminaria;
        $censo = CensoLuminaria::where('codigo_luminaria', $codigo)->orderBy('id', 'desc')->first();
        $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
        $departamentos = Departamento::get();
        $municipios = Municipio::where('departamento_id', $censo->distrito->municipio->departamento_id)->get();
        $distritos = Distrito::where('municipio_id', '=', $censo->distrito->municipio_id)->get();
        $potencias_promedio = PotenciaPromedio::where('tipo_luminaria_id', '=', $censo->tipo_luminaria_id)->get();

        $registros = CensoLuminaria::where('codigo_luminaria', $censo->codigo_luminaria)->orderBy('id', 'desc')->get();
        $tipos_falla = TipoFalla::where('activo', '1')->get();


        return view('control.censo_luminaria.show', compact('censo', 'tipos', 'departamentos', 'municipios', 'distritos', 'potencias_promedio', 'registros', 'tipos_falla'));
    }


    public function create_record(Request $request)
    {
        $codigo = $request->codigo_luminaria;
        $censo = new CensoLuminaria();


        $censo->tipo_luminaria_id = $request->tipo_luminaria_id;
        $censo->potencia_nominal = $request->potencia_nominal;
        $censo->consumo_mensual = $request->consumo_mensual;
        $censo->distrito_id = $request->distrito_id;
        $censo->usuario_ingreso = auth()->user()->id;
        $censo->direccion = $request->direccion;
        $censo->codigo_luminaria = $codigo;
        $censo->latitud = $request->latitud;
        $censo->longitud = $request->longitud;
        $censo->observacion = $request->observacion;
        if ($request->condicion_lampara != null) {
            $censo->condicion_lampara = 1;
        } else {
            $censo->condicion_lampara = 0;
        }
        if ($request->tipo_falla_id != null) {
            $censo->tipo_falla_id = $request->tipo_falla_id;
        } else {
            $censo->tipo_falla_id = null;
        }
        $censo->save();


        $url_en_qr =  $codigo;

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
                //$this->info("Archivo eliminado: {$file}");
            }
        }



        return view('control.censo_luminaria.resumen', compact('censo'));
    }


    public function show_map_edit($id)
    {
        $configuracion = Configuracion::first();
        $censo = CensoLuminaria::findOrFail($id);

        return view('control.censo_luminaria.map_edit', compact('configuracion', 'censo'));
    }
    public function edit($id)
    {
        $configuracion = Configuracion::first();
        $censo = CensoLuminaria::findOrFail($id);

        return view('control.censo_luminaria.map_edit', compact('configuracion', 'censo'));

        /*$censo = CensoLuminaria::findOrFail($id);
        $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
        $departamentos = Departamento::get();
        $distritos = Distrito::where('departamento_id', '=', $censo->distrito->municipio->deaprtamento_id)->get();

        $potencias_promedio = PotenciaPromedio::where('tipo_luminaria_id', '=', $censo->tipo_luminaria_id)->get();

        return view('control.censo_luminaria.edit', compact('censo', 'tipos', 'departamentos', 'distritos', 'potencias_promedio'));*/
    }

    public function edit_censo(Request $request)
    {
        $censo = CensoLuminaria::findOrFail($request->id);
        $potencias_promedio = PotenciaPromedio::where('tipo_luminaria_id', $censo->tipo_luminaria_id)->get();
        $latitude = $request->latitude;
        $longitude = $request->longitude;


        $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$latitude}&lon={$longitude}";

        $client = new Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'User-Agent' => 'MyLaravelApp/1.0 (contact@myapp.com)'
            ]
        ]);
        $data = json_decode($response->getBody(), true);

        $distrito = Distrito::findOrFail($censo->distrito_id);
        $companias = $distrito->companias;

        $municipios = Municipio::where('departamento_id', $censo->distrito->municipio->departamento_id)->get();
        $distritos = Distrito::where('municipio_id', $censo->distrito->municipio_id)->get();

        $tipos = TipoLuminaria::where('Activo', '=', 1)->get();
        $departamentos = Departamento::get();
        $configuracion = Configuracion::first();
        $tipos_falla = TipoFalla::where('activo', '1')->get();


        //dd($censo);


        return view('control.censo_luminaria.edit', compact('censo', 'tipos', 'departamentos', 'distritos', 'municipios', 'potencias_promedio', 'companias', 'tipos_falla'));
    }


    public function update(Request $request, $id)
    {
        $censo = CensoLuminaria::findOrFail($id);
        $censo->tipo_luminaria_id = $request->tipo_luminaria_id;
        if ($request->potencia_promedio) {
            $censo->potencia_nominal = $request->potencia_promedio;
        } else {
            $censo->potencia_nominal = $request->potencia_nominal;
        }

        $censo->consumo_mensual = $request->consumo_mensual;
        $censo->distrito_id = $request->distrito_id;
        $censo->direccion = $request->direccion;
        $censo->codigo_luminaria = $request->codigo_luminaria;
        $censo->latitud = $request->latitud;
        $censo->longitud = $request->longitud;
        $censo->observacion = $request->observacion;
        if ($request->condicion_lampara != null) {
            $censo->condicion_lampara = 1;
        } else {
            $censo->condicion_lampara = 0;
            $censo->tipo_falla_id = $request->tipo_falla_id;
        }

        $censo->compania_id = $request->compania_id;
        $censo->save();

        alert()->success('El registro ha sido creado correctamente');


        return back();
    }

    public function destroy($id)
    {
        $censo = CensoLuminaria::findOrFail($id);
        $censo->delete();
        alert()->success('El registro ha sido eliminado correctamente');
        return back();
    }
}
