<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use App\Models\catalogo\TipoFalla;
use App\Models\control\ReporteFalla;
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

    public function create()
    {
        $departamentos = Departamento::get();
        $tipos = TipoFalla::get();

        $response = ["departamentos" => $departamentos, "tipos" => $tipos];

        return $response;
    }



    public function getMunicipios($id)
    {
        $municipios = Municipio::where('departamento_id', '=', $id)->get();

        return ["distritos" => $municipios];
    }


    public function getDistritos($id)
    {
        $distritos = Distrito::where('municipio_id', '=', $id)->get();

        return ["distritos" => $distritos];
    }

    public function store(Request $request)
    {
        try {

            $fechaActual = Carbon::now();

            $reporte_falla = new ReporteFalla();
            $reporte_falla->fecha = $fechaActual->format('Y-m-d');
            $reporte_falla->distrito_id = $request->distrito_id;
            $reporte_falla->tipo_falla_id = $request->tipo_falla_id;
            $reporte_falla->descripcion = $request->descripcion;
            $reporte_falla->latitud = $request->latitud;
            $reporte_falla->longitud = $request->longitud;
            $reporte_falla->telefono_contacto = $request->telefono_contacto;
            $reporte_falla->nombre_contacto = $request->nombre_contacto;
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

                $reporte_falla->url_foto = $nombre ;
            }

            $reporte_falla->save();

            $response = ["value" => "1", "mensaje" => "Registro ingresado correctamente"];
        } catch (Exception $e) {
            $response = ["value" => "0", "mensaje" => "Error al procesar la solicitud"];
        }

        return $response;
    }


    public function getDepartamentoId($name)
    {
        $nombreSinDepartamento = str_replace("Departamento de", "", $name);
        $nombreFinal = trim($nombreSinDepartamento);

        $departamentoModel = new Departamento();
        $departamentoId = $departamentoModel->getDepartamentoId($nombreFinal);

        return response()->json(['departamentoId' => $departamentoId]);
    }

    public function getDistritoId($name)
    {
        $nombreSinDistrito = str_replace("Municipio de", "", $name);
        $nombreFinal = trim($nombreSinDistrito);

        $distritoModel = new Distrito();
        $distritoId = $distritoModel->distritoId($nombreFinal);

        return response()->json(['distritoId' => $distritoId]);
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
