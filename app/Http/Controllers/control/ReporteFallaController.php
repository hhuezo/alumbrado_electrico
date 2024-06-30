<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Compania;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\TipoFalla;
use App\Models\catalogo\TipoLuminaria;
use App\Models\Configuracion;
use App\Models\control\CensoLuminaria;
use App\Models\control\ReporteFalla;
use App\Models\control\ReporteFallaSeguimiento;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ReporteFallaController extends Controller
{
    public function index()
    {
        $reporte_fallas = ReporteFalla::get();

        return view('control.reporte_falla.index', compact('reporte_fallas'));
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

            $companias = Compania::where('activo',1)->get();

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

            $user = User::findOrFail(auth()->user()->id);
            $role_id = $user->user_rol->pluck('id')->toArray();

            if (in_array(3, $role_id) || in_array(4, $role_id)) {
                $distritos_id = $user->distritos->pluck('id')->toArray();
                $municipios = $user->get_municipios($user->id);
                $distritos = Distrito::whereIn('id', $distritos_id)->get();
                $departamentos = $user->get_departamentos($user->id);

            }



            return view('control.reporte_falla.create', compact(
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
        $reporte_falla->usuario_creacion = auth()->user()->id;
        $reporte_falla->fecha_creacion = Carbon::now();

        if ($request->file('archivo')) {
            $file = $request->file('archivo');
            $id_file = uniqid();
            $file->move(public_path("docs/"), $id_file . ' ' . $file->getClientOriginalName());
            $reporte_falla->url_foto = $id_file . ' ' . $file->getClientOriginalName();
        }

        $reporte_falla->save();
        alert()->success('El registro ha sido creado correctamente');
        return Redirect::to('reporte_falla');
    }

    public function show($id)
    {
        $reporte_falla = ReporteFalla::findOrFail($id);
          if($reporte_falla->censo_luminaria_id != null)
        {

            return Redirect::to('reporte_falla/registrar_falla?id='.$reporte_falla->id.'&censo_id='.$reporte_falla->censo_luminaria_id);
        }
        $configuracion = Configuracion::first();

        $censo_luminarias = CensoLuminaria::select('id', 'latitud', 'longitud')->groupBy('latitud', 'longitud')->get();

        $points = $censo_luminarias->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'lat' => (float)$item->latitud,
                'lng' => (float)$item->longitud,
                'title' => 'Punto ' . ($key + 1)
            ];
        });

        return view('control.reporte_falla.show', compact('reporte_falla', 'configuracion', 'points'));
    }


    public function registrar_falla(Request $request)
    {
        $reporte_falla = ReporteFalla::findOrFail($request->id);
        $censo = CensoLuminaria::findOrFail($request->censo_id);
        $tipos_falla = TipoFalla::where('activo', 1)->get();
        return view('control.reporte_falla.registrar_falla', compact('reporte_falla', 'censo', 'tipos_falla'));
    }

    public function store_falla(Request $request)
    {
        // Define the validation rules
        $rules = [
            'censo_id' => 'required|integer',
            'fecha' => 'required',
            'reporte_falla_id' => 'required|integer',
            'observacion' => 'required|string',
        ];

        // Add a custom validation rule for tipo_falla_id
        if ($request->condicion_lampara == null) {
            $rules['tipo_falla_id'] = 'required|integer';
        }

        // Define custom validation messages
        $messages = [
            'censo_id.required' => 'El campo censo_id es obligatorio.',
            'censo_id.integer' => 'El campo censo_id debe ser un número entero.',
            'reporte_falla_id.required' => 'El campo reporte_falla_id es obligatorio.',
            'reporte_falla_id.integer' => 'El campo reporte_falla_id debe ser un número entero.',
            'observacion.required' => 'El campo observación es obligatorio.',
            'observacion.string' => 'El campo observación debe ser un texto.',
            'tipo_falla_id.required' => 'El tipo de falla es obligatorio cuando la lámpara no está en buenas condiciones.',
            'tipo_falla_id.integer' => 'El falla debe ser un número entero.',
            'fecha.required' => 'La fecha es obligatoria.',
        ];

        // Validate the request data with custom messages
        $validatedData = $request->validate($rules, $messages);

        // Create a new instance of ReporteFallaSeguimiento
        $reporteFallaSeguimiento = new ReporteFallaSeguimiento();
        $reporteFallaSeguimiento->reporte_falla_id = $request->reporte_falla_id;
        $reporteFallaSeguimiento->censo_luminaria_id = $request->censo_id;
        $reporteFallaSeguimiento->fecha = $request->fecha;
        $reporteFallaSeguimiento->usuario_creacion = auth()->user()->id;
        if ($request->condicion_lampara == null) {
            $reporteFallaSeguimiento->condicion_lampara = 0;
        } else {
            $reporteFallaSeguimiento->condicion_lampara = 1;
        }
        $reporteFallaSeguimiento->observacion = $request->observacion;


        if (isset($request->tipo_falla_id)) {
            $reporteFallaSeguimiento->tipo_falla_id = $request->tipo_falla_id;
        }
        $reporteFallaSeguimiento->estado_reporte_falla_id = 2;

        // Save the new record to the database
        $reporteFallaSeguimiento->save();

        $reporte_falla = ReporteFalla::findOrFail($request->reporte_falla_id);
        $reporte_falla->estado_reporte_id = 2;
        $reporte_falla->censo_luminaria_id = $request->censo_id;
        $reporte_falla->save();

        $censo = CensoLuminaria::findOrFail($request->censo_id);
        if ($request->condicion_lampara == null) {
            $censo->condicion_lampara = 0;
            $censo->tipo_falla_id = $request->tipo_falla_id;
        } else {
            $censo->condicion_lampara = 1;
            $censo->tipo_falla_id =  null;
        }
        $censo->save();

        alert()->success('El registro ha sido creado correctamente');


        return back();
    }

    public function show_map()
    {
        $configuracion = Configuracion::first();
        return view('control.reporte_falla.map', compact('configuracion'));
    }


    public function finalizar_falla(Request $request)
    {

        $reporteFallaSeguimiento = new ReporteFallaSeguimiento();
        $reporteFallaSeguimiento->reporte_falla_id = $request->reporte_falla_id;
        $reporteFallaSeguimiento->censo_luminaria_id = $request->censo_id;
        $reporteFallaSeguimiento->fecha = $request->fecha;
        $reporteFallaSeguimiento->condicion_lampara = 1;
        $reporteFallaSeguimiento->observacion = $request->observacion;
        $reporteFallaSeguimiento->estado_reporte_falla_id = 3;
        $reporteFallaSeguimiento->usuario_creacion = auth()->user()->id;

        // Save the new record to the database
        $reporteFallaSeguimiento->save();

        $reporte_falla = ReporteFalla::findOrFail($request->reporte_falla_id);
        $reporte_falla->estado_reporte_id = 3;
        $reporte_falla->save();

        $censo = CensoLuminaria::findOrFail($request->censo_id);
        $censo->condicion_lampara = 1;
        $censo->tipo_falla_id =  null;

        $censo->save();

        alert()->success('El registro ha sido creado correctamente');


        return back();
    }


    public function edit($id)
    {
        //
    }

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
