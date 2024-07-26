<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\TipoFalla;
use App\Models\control\ReporteFalla;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReporteFallaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        $departamentos = Departamento::get();
        $tipos = TipoFalla::get();

        $response = ["departamentos" => $departamentos, "tipos" => $tipos];

        return $response;
    }



    public function getMunicipios(Request $request,$id)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        $municipios = Municipio::where('departamento_id', '=', $id)->get();

        return ["municipios" => $municipios];
    }


    public function getDistritos(Request $request,$id)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        $distritos = Distrito::where('municipio_id', '=', $id)->get();

        return ["distritos" => $distritos];
    }

    public function store(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        try {

            $fechaActual = Carbon::now();

            $reporte_falla = new ReporteFalla();

            if($request->usuario_id !=""){
                $reporte_falla->usuario_creacion = $request->usuario_id;
            }
            $reporte_falla->fecha = $fechaActual->format('Y-m-d');
            $reporte_falla->distrito_id = $request->distrito_id;
            $reporte_falla->tipo_falla_id = $request->tipo_falla_id;
            $reporte_falla->descripcion = $request->descripcion;
            $reporte_falla->latitud = $request->latitud;
            $reporte_falla->longitud = $request->longitud;
            $reporte_falla->telefono_contacto = $request->telefono_contacto;
            $reporte_falla->nombre_contacto = $request->nombre_contacto;
            $reporte_falla->correo_contacto = $request->correo_contacto;
            $reporte_falla->estado_reporte_id = 1;
            if ($request->imagen) {
                $base64Image = $request->input('imagen'); // Obtener la cadena de base64 desde la solicitud
                $decodedImage = base64_decode($base64Image); // Decodificar la cadena de base64

                // Generar un nombre único para el archivo
                $idFile = uniqid();
                $nombre = $idFile  . '.png';

                // Guardar la imagen en el directorio deseado
                $ruta = public_path("docs/" . $nombre);
                file_put_contents($ruta, $decodedImage);

                $reporte_falla->url_foto = $nombre;
            }

            $reporte_falla->save();

            $response = ["value" => "1", "mensaje" => "Registro ingresado correctamente"];
        } catch (Exception $e) {
            $response = ["value" => "0", "mensaje" => "Error al procesar la solicitud"];
        }

        return $response;
    }


    public function getDepartamentoId(Request $request,$name)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        $nombreSinDepartamento = str_replace("Departamento de", "", $name);
        $nombreFinal = trim($nombreSinDepartamento);

        $departamentoModel = new Departamento();
        $departamentoId = $departamentoModel->getDepartamentoId($nombreFinal);

        return response()->json(['departamentoId' => $departamentoId]);
    }

    public function getMunicipioId(Request $request,$distrito_id)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        if ($distrito_id != 0) {
            $distrito = Distrito::findOrFail($distrito_id);

            $municipioId = $distrito->municipio_id;
        } else {
            $municipioId = 0;
        }

        return response()->json(['municipioId' => $municipioId]);
    }

    public function getDistritoId(Request $request,$name)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        $nombreSinDistrito = str_replace("Distrito de", "", $name);
        $nombreFinal = trim($nombreSinDistrito);

        $distritoModel = new Distrito();
        $distritoId = $distritoModel->distritoId($nombreFinal);

        return response()->json(['distritoId' => $distritoId]);
    }

    public function data_distrito(Request $request,$distrito,$departamento)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        if($distrito>0)
        {
            $distrito = Distrito::findOrfail($distrito);

            $distritos = Distrito::where('municipio_id',$distrito->municipio_id)->select("id","nombre")->get();
            $municipio_id = $distrito->municipio_id;

            $municipios = Municipio::where('departamento_id',$distrito->municipio->departamento_id)->select("id","nombre")->get();
        }
        else{
            $municipios = Municipio::where('departamento_id',$departamento)->select("id","nombre")->get();
            $municipio  = Municipio::where('departamento_id',$departamento)->first();
            $municipio_id = $municipio->id;
            $distritos = Distrito::where('municipio_id',$municipio->id)->select("id","nombre")->get();
        }

        $response = ["value" => "1", "mensaje" => "ok","distritos"=>$distritos,"municipios"=>$municipios,"municipio"=>$municipio_id];

        return response()->json(['response' => $response]);
    }


    public function getDistritoUsuario(Request $request,$name, $usuario_id)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader !== 'Basic dXNlcjpwYXNz') {
            return response()->json(['value' => 0, 'mensaje' => 'Encabezado de autorización incorrecto'], 401);
        }

        $id_distrito_valido = true;
        $nombreSinDistrito = str_replace("Distrito de", "", $name);
        $nombreFinal = trim($nombreSinDistrito);

        $distritoModel = new Distrito();
        $distritoId = $distritoModel->distritoId($nombreFinal);

        $user = User::findOrFail($usuario_id);
        $role_id = $user->user_rol->pluck('id')->toArray();

        if (in_array(3, $role_id) || in_array(4, $role_id)) {

            $distritos_id = $user->distritos->pluck('id')->toArray();

            if (!in_array($distritoId, $distritos_id)) {
                $id_distrito_valido = false;
            }
        }

        return response()->json(['distritoId' => $distritoId,'id_distrito_valido'=>$id_distrito_valido]);
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
