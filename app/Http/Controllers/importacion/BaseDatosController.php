<?php

namespace App\Http\Controllers\importacion;

use App\Http\Controllers\Controller;
use App\Imports\DataBaseImport;
use App\Models\BaseDatosSiget;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\PotenciaPromedio;
use App\Models\Configuracion;
use App\Models\control\CensoLuminaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BaseDatosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /*$data = BaseDatosSiget::select("municipio as Municipio","tipo_luminaria.nombre as Tipo","potencia_nominal as Potencia",
        "consumo_mensual as ConsumoMensual","numero_luminarias as NumeroLuminarias")
        ->join('tipo_luminaria','tipo_luminaria.id','=','base_datos_siget.tipo_luminaria_id')
        ->get();

        foreach($data as $record)
        {
            $record->ConsumoMensual = intval($record->ConsumoMensual);
        }



       // $datafields = ["municipio","tipo_luminaria_id","potencia_nominal","consumo_mensual","numero_luminarias"];
       $datafields = ["Municipio","Tipo","Potencia","ConsumoMensual","NumeroLuminarias"];

        return view('importacion.base_datos',compact('datafields','data'));*/

        $meses = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];

        return view('importacion.base_datos', compact('meses'));
    }

    public function create()
    {
        $maxAnio = DB::table('base_datos_siget')->max('anio');

        $registro = DB::table('base_datos_siget')
            ->select('anio', 'mes')
            ->where('anio', $maxAnio)
            ->where('mes', function ($query) use ($maxAnio) {
                $query->select(DB::raw('MAX(mes)'))
                    ->from('base_datos_siget')
                    ->where('anio', $maxAnio);
            })->first();

        $data = BaseDatosSiget::where('anio', $registro->anio)->where('mes', $registro->mes)
            ->select(
                'tipo_luminaria_id',
                'potencia_nominal',
                'consumo_mensual',
                DB::raw('(select count(potencia_promedio.id) from potencia_promedio
                where potencia_promedio.tipo_luminaria_id = base_datos_siget.tipo_luminaria_id
                and potencia_promedio.potencia = base_datos_siget.potencia_nominal ) as conteo')
            )
            ->orderBy('consumo_mensual')
            ->groupBy('tipo_luminaria_id', 'potencia_nominal')
            ->having('conteo', '=', 0)->get();

        foreach ($data as $record) {
            $potencia = new PotenciaPromedio();
            $potencia->tipo_luminaria_id = $record->tipo_luminaria_id;
            $potencia->potencia = $record->potencia_nominal;
            $potencia->consumo_promedio = $record->consumo_mensual;
            $potencia->save();
        }
    }

    public function store(Request $request)
    {

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $sheetCount = $spreadsheet->getSheetCount();
            if ($sheetCount != 1) {
                return back()->withErrors(['file' => 'El documento debe tener una sola hoja']);
            }

            BaseDatosSiget::where('anio', $request->anio)->where('mes', $request->mes)->delete();
            $import = new DataBaseImport($request->anio, $request->mes);
            Excel::import($import, $file);

            DB::table('base_datos_siget as b')
                ->join('compania as c', 'b.compania', '=', 'c.nombre')
                ->whereNull('b.compania_id')
                ->orWhere('b.compania_id', '')
                ->update(['b.compania_id' => DB::raw('c.id')]);

            $registros = BaseDatosSiget::select('municipio_id', 'compania_id', 'poblacion', 'area')->groupBy('municipio_id')
                ->where('anio', $request->anio)->where('mes', $request->mes)->get();

            foreach ($registros as $registro) {

                $distrito = Distrito::where('codigo', $registro->municipio_id)->first();
                if ($distrito) {
                    // Borrar los datos existentes en la tabla distrito_has_compania para el distrito actual
                    DB::table('distrito_has_compania')->where('distrito_id', $distrito->id)->delete();

                    // Insertar los nuevos datos en la tabla distrito_has_compania
                    DB::table('distrito_has_compania')->insert([
                        'distrito_id' => $distrito->id,
                        'compania_id' => $registro->compania_id,
                    ]);

                    //agregarn poblacion y area
                    $distrito->poblacion = $registro->poblacion;
                    $distrito->extension_territorial = $registro->area;
                    $distrito->save();
                }
            }

            //creando potencias
            $data = BaseDatosSiget::where('anio', $request->anio)->where('mes', $request->mes)
                ->select(
                    'tipo_luminaria_id',
                    'potencia_nominal',
                    'consumo_mensual',
                    DB::raw('(select count(potencia_promedio.id) from potencia_promedio
                where potencia_promedio.tipo_luminaria_id = base_datos_siget.tipo_luminaria_id
                and potencia_promedio.potencia = base_datos_siget.potencia_nominal ) as conteo')
                )
                ->orderBy('consumo_mensual')
                ->groupBy('tipo_luminaria_id', 'potencia_nominal')
                ->having('conteo', '=', 0)->get();

            foreach ($data as $record) {
                $potencia = new PotenciaPromedio();
                $potencia->tipo_luminaria_id = $record->tipo_luminaria_id;
                $potencia->potencia = $record->potencia_nominal;
                $potencia->consumo_promedio = $record->consumo_mensual;
                $potencia->save();
            }


            alert()->success('El registro ha sido creado correctamente');
            return back();
        } catch (\Exception $e) {
            // Capturar y mostrar el error 500
            return back()->withErrors(['file' => $e->getMessage()])->withInput();
        }
    }


    /*public function store(Request $request)
    {
        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $sheetCount = $spreadsheet->getSheetCount();
            if ($sheetCount != 1) {
                return back()->withErrors(['file' => 'El documento debe tener una sola hoja']);
            }

            //BaseDatosSiget::truncate();

            BaseDatosSiget::where('anio', $request->anio)->where('mes', $request->mes)->delete();
            $import = new DataBaseImport($request->anio, $request->mes);
            Excel::import($import, $file);

            alert()->success('El registro ha sido creado correctamente');
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['file' => $e->getMessage()]);
        }



        /*BaseDatosSiget::truncate();


        try {
            $file = $request->file('file');
            Excel::import(new DataBaseImport, $file);

            $import = new DataBaseImport;
            $errors = $import->getErrors();

            if (!empty($errors)) {
                throw ValidationException::withMessages(['import' => $errors]);
            }



        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // fila en la que ocurrió el error
                $failure->attribute(); // el número de columna o la "llave" de la columna
                $failure->errors(); // Errores de las validaciones de laravel
                $failure->values(); // Valores de la fila en la que ocurrió el error.
            }
        }

        return back();
    }*/

    public function show($id)
    {
        $configuracion = Configuracion::first();
        $censos = CensoLuminaria::get();

        $array_data = [];
        foreach ($censos as $censo) {
            if ($censo->tipo_luminaria->icono) {
                $array = ["lat" => $censo->latitud + 0, "lng" => $censo->longitud + 0, "shortDescription" => "Cod: " . $censo->codigo_luminaria, "icono" => $censo->tipo_luminaria->icono];
            } else {
                $array = ["lat" => $censo->latitud + 0, "lng" => $censo->longitud + 0, "shortDescription" => "Cod: " . $censo->codigo_luminaria, "icono" => "poste.png"];
            }

            array_push($array_data, $array);
        }

        return view('importacion.show', compact('configuracion', 'array_data'));
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
