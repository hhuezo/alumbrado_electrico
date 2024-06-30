<?php

namespace App\Http\Controllers\publico;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Compania;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\TipoFalla;
use App\Models\Configuracion;
use App\Models\control\ReporteFalla;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReporteFallaPublicoController extends Controller
{

    public function index()
    {
        // $departamentos = Departamento::get();
        // $tipos = TipoFalla::get();
        // $configuracion = Configuracion::first();

        $configuracion = Configuracion::first();
        return view('publico.map', compact('configuracion'));
    }

    public function create(Request $request)
    {
        if ($request->latitude && $request->longitude) {
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

            $id_departamento = null;
            $id_distrito = null;
            $distritos = null;
            $direccion = null;
            $municipios = null;
            $municipio_id = null;
            $id_distrito_valido = 1;



            if (isset($data['address'])) {
                $api_departamento = $data['address']['state'];
                $api_departamento = str_replace("Departamento de ", "", $api_departamento);
                $api_municipio = $data['address']['city'] ?? $data['address']['town'] ?? $data['address']['village'] ?? ($data['address']['county'] ?? null);

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
                                $companias = $distrito->companias;
                                $distritos = Distrito::where('municipio_id', $distrito->municipio_id)->get();

                                $id_distrito = $distrito->id;
                                $municipio_id = $distrito->municipio_id;
                            }
                        } else {

                            $municipio = $municipios->first();
                            $municipio_id  = $municipio->id;
                            $distritos = Distrito::where('municipio_id', $municipio_id)->get();
                        }
                    }
                }
            } else {
                // Manejar la situación donde no se pudo obtener la información de ubicación
                \Log::error("No se pudo obtener la información de ubicación.");
            }


            $departamentos = Departamento::get();
            $configuracion = Configuracion::first();
            $tipos_falla = TipoFalla::where('activo', '1')->get();





            return view('publico.reporte_falla', compact(
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
                'tipos_falla',
                'id_distrito_valido'
            ));
        } else {
            alert()->error('la ubicacion es incorrecta');
            return back();
        }
    }

    public function store(Request $request)
    {
        $messages = [
            'tipo_falla_id.required' => 'El tipo de falla es requerido',
            'distrito_id.required' => 'El distrito es requerido',
            'descripcion.required' => 'La descripción es requerida',
            'fecha.required' => 'La fecha es requerida',
            'latitud.required' => 'La ubicación es requerida',
            'nombre_contacto.required' => 'El nombre es requerido',
            'telefono_contacto.required' => 'El teléfono es requerido',
            'telefono_contacto.regex' => 'El formato del teléfono es incorrecto.',
        ];

        $request->validate([
            'tipo_falla_id' => 'required',
            'distrito_id' => 'required',
            'descripcion' => 'required',
            'latitud' => 'required',
            'nombre_contacto' => 'required',
            'telefono_contacto' => 'required|regex:/^\d{4}-\d{4}$/',
        ], $messages);


        $reporte_falla = new ReporteFalla();
        $reporte_falla->fecha = Carbon::now()->format('Y-m-d');
        $reporte_falla->distrito_id = $request->distrito_id;
        $reporte_falla->tipo_falla_id = $request->tipo_falla_id;
        $reporte_falla->descripcion = $request->descripcion;
        $reporte_falla->latitud = $request->latitud;
        $reporte_falla->longitud = $request->longitud;
        $reporte_falla->telefono_contacto = $request->telefono_contacto;
        $reporte_falla->nombre_contacto = $request->nombre_contacto;
        $reporte_falla->correo_contacto = $request->correo_contacto;
        $reporte_falla->estado_reporte_id = 1;
        //$reporte_falla->usuario_creacion = auth()->user()->id;
        $reporte_falla->fecha_creacion = Carbon::now();

        if ($request->file('archivo')) {
            $file = $request->file('archivo');
            $id_file = uniqid();
            $file->move(public_path("docs/"), $id_file . ' ' . $file->getClientOriginalName());
            $reporte_falla->url_foto = $id_file . ' ' . $file->getClientOriginalName();
        }

        $reporte_falla->save();
        alert()->success('El registro ha sido creado correctamente');
        return Redirect::to('/');

        return view('publico.reporte_falla_mensaje');
        //return back();
    }


    public function get_distritos($id)
    {
        return Distrito::where('departamento_id', '=', $id)->get();
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
