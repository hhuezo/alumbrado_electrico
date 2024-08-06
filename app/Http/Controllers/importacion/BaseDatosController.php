<?php

namespace App\Http\Controllers\importacion;

use App\Exports\LuminariasExport;
use App\Http\Controllers\Controller;
use App\Imports\CensoLuminariasImport;
use App\Imports\DataBaseImport;
use App\Models\BaseDatosSiget;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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

    public function show(Request $request, $id)
    {

        $censos = CensoLuminaria::get();
       

        $departamento_id = 0;
        $municipio_id = 0;
        $distrito_id = 0;




        if ($request->departamento_id) {
            $departamento_id = $request->departamento_id;
        }

        if ($request->municipio_id) {
            $municipio_id = $request->municipio_id;
        }

        if ($request->distrito_id) {
            $distrito_id = $request->distrito_id;
            $censos = CensoLuminaria::where('distrito_id',$distrito_id)->get();
        }

        $configuracion = Configuracion::first();


        $departamentos = Departamento::get();
        $municipios = null;
        if ($request->municipio_id) {
            $obj_municipio = Municipio::findOrFail($request->municipio_id);
            if ($obj_municipio) {
                $municipios = Municipio::where('departamento_id', $obj_municipio->departamento_id)->get();
            }
        }

        $distritos = null;
        if ($request->distrito_id) {
            $obj_distrito = Distrito::findOrFail($request->distrito_id);
            if ($obj_distrito) {
                $distritos = Distrito::where('municipio_id', $obj_distrito->municipio_id)->get();
            }
        }

        $array_data = [];
        foreach ($censos as $censo) {
            if ($censo->tipo_luminaria->icono) {
                $array = ["lat" => $censo->latitud + 0, "lng" => $censo->longitud + 0, "shortDescription" => "Cod: " . $censo->codigo_luminaria, "icono" => $censo->tipo_luminaria->icono];
            } else {
                $array = ["lat" => $censo->latitud + 0, "lng" => $censo->longitud + 0, "shortDescription" => "Cod: " . $censo->codigo_luminaria, "icono" => "poste.png"];
            }

            array_push($array_data, $array);
        }

        return view('importacion.show', compact(
            'configuracion',
            'array_data',
            'departamentos',
            'municipios',
            'distritos',
            'departamento_id',
            'municipio_id',
            'distrito_id'
        ));
    }


    public function importar_base(Request $request)
    {

        if (auth()->user()->hasRole('administrador')) {
            $distritos = Distrito::get();
        } else {
            $distritos = User::findOrFail(auth()->user()->id)->distritos;
        }
        //dd($distritos);

        return view('importacion.censo_luminarias', compact('distritos'));
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

    public function importar_censo_luminaria(Request $request)
    {

        $archivo = $request->archivo;
        $distrito_id = $request->distrito_id;
        try {
            $imports = Excel::toArray(new CensoLuminariasImport, $archivo);

            foreach ($imports as $import) {
                unset($import[0]);  //descartar los encabezados
                $censos = array_values($import);
            }

            // dd($censos);
            foreach ($censos as $censo) {
                if ($censo['0'] != null) {


                    /*
                $censo['0'] correlativo
                $censo['1'] tipo luminaria
                $censo['2'] potencia nominal
                $censo['3'] consumo mensual
                $censo['4'] fecha de ultimo censo
                $censo['5'] densidad luminica
                $censo['6'] latitud
                $censo['7'] longitud
                $censo['8'] direccion
                $censo['9'] observacion
                $censo['10'] tipo de falla
                $censo['11'] condicion lampara
                $censo['12'] compañia
                */
                    // fecha de ultimo censo
                    if (is_numeric($censo['4'])) {
                        $fecha_ultimo_censo = Date::excelToDateTimeObject($censo['4'])->format('Y-m-d');
                    } else {
                        $fecha_ultimo_censo = $censo['4'];  // Si no es un número, mantener el valor original
                    }

                    // tipo luminaria

                    $tipo_luminaria_existe = TipoLuminaria::where('nombre', 'like', '%' . $censo['1'] . '%')->first();

                    if (!$tipo_luminaria_existe) {
                        $tipo_luminaria = new TipoLuminaria();
                        $tipo_luminaria->nombre = $censo['1'];
                        $tipo_luminaria->save();
                        $tipo_lum_id = $tipo_luminaria->id;
                    } else {
                        $tipo_lum_id = $tipo_luminaria_existe->id;
                    }

                    //codigo_luminaria
                    $codigo = $this->getCodigo($request->distrito_id);

                    //tipo de falla
                    $tipo_falla_existe = TipoFalla::where('nombre', 'like', '%' . $censo['1'] . '%')->first();

                    if (!$tipo_falla_existe) {
                        $tipo_falla = new TipoFalla();
                        $tipo_falla->nombre = $censo['10'];
                        $tipo_falla->save();
                        $tipo_falla_id = $tipo_falla->id;
                    } else {
                        $tipo_falla_id = $tipo_falla_existe->id;
                    }

                    //compañia
                    $compania_existe = Compania::where('nombre', 'like', '%' . $censo['12'] . '%')->first();
                    if (!$compania_existe) {
                        $compania = new TipoFalla();
                        $compania->nombre = $censo['10'];
                        $compania->save();
                        $compania_id = $compania->id;
                    } else {
                        $compania_id = $compania_existe->id;
                    }

                    $censo_nuevo = new CensoLuminaria();
                    $censo_nuevo->tipo_luminaria_id = $tipo_lum_id;
                    $censo_nuevo->potencia_nominal = $censo['2'];
                    $censo_nuevo->consumo_mensual = $censo['3'];
                    $censo_nuevo->fecha_ultimo_censo = $fecha_ultimo_censo;
                    $censo_nuevo->distrito_id = $distrito_id;
                    $censo_nuevo->usuario_ingreso = auth()->user()->id;
                    $censo_nuevo->codigo_luminaria = $codigo;
                    $censo_nuevo->decidad_luminicia = $censo['5'];
                    $censo_nuevo->latitud = $censo['6'];
                    $censo_nuevo->longitud = $censo['7'];
                    $censo_nuevo->usuario_creacion = auth()->user()->id;
                    $censo_nuevo->usuario_modificacion = auth()->user()->id;
                    $censo_nuevo->direccion = $censo['8'];
                    $censo_nuevo->observacion = $censo['9'];
                    $censo_nuevo->tipo_falla_id = $tipo_falla_id;
                    $censo_nuevo->condicion_lampara = $censo['11'];
                    $censo_nuevo->compania_id = $compania_id;
                    $censo_nuevo->save();
                }
            }

            alert()->success('El registro ha sido creado correctamente');
            return redirect('/importar_luminarias');
        } catch (\Throwable $th) {
            //throw $th;
        }
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
