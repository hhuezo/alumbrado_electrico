<?php

namespace App\Http\Controllers\importacion;

use App\Http\Controllers\Controller;
use App\Imports\DataBaseImport;
use App\Models\BaseDatosSiget;
use App\Models\Configuracion;
use App\Models\control\CensoLuminaria;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BaseDatosController extends Controller
{

    public function index()
    {
        return view('importacion.base_datos');
    }

    public function create()
    {
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

            BaseDatosSiget::truncate();
            $import = new DataBaseImport;
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

        return back();*/
    }

    public function show($id)
    {
        $configuracion = Configuracion::first();
        $censos = CensoLuminaria::get();

        $array_data = [];
        foreach($censos as $censo)
        {
            $array = ["lat"=>$censo->latitud +0,"lng"=>$censo->longitud +0, "shortDescription"=> "Cod: ".$censo->codigo_luminaria];
            array_push($array_data,$array );

        }

        return view('importacion.show', compact('configuracion','array_data'));
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
