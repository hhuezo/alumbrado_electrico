<?php

namespace App\Exports;

use App\Models\catalogo\TipoFalla;
use App\Models\catalogo\TipoLuminaria;
use App\Models\catalogo\Compania; // Import the Compania model
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CensoLuminariasExport implements FromArray, WithHeadings, WithEvents
{
    // Definimos los encabezados
    public function headings(): array
    {
        return [
            'Tipo Luminaria',
            'Potencia Nominal',
            'Fecha Último Censo',
            'Latitud',
            'Longitud',
            'Direccion',
            'Observacion',
            'Tipo Falla',
            'Condicion Lampara',
            'Compañía',
        ];
    }

    // Retornamos un array vacío ya que no queremos datos en la primera página
    public function array(): array
    {
        return [];
    }

    // Implementamos el método de eventos
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $spreadsheet = $event->sheet->getDelegate()->getParent();

                // Crear una nueva hoja (página 2)
                $newSheet = $spreadsheet->createSheet();
                $newSheet->setTitle('Catálogos');

                // Preparar los datos para la nueva hoja
                $data_tipos_falla = [];
                $tipos_falla = TipoFalla::all();

                // Agregar el encabezado
                $data_tipos_falla[] = ['Tipos de falla'];

                // Agregar cada tipo de falla en una nueva fila
                foreach ($tipos_falla as $tipo) {
                    $data_tipos_falla[] = [$tipo->nombre];
                }

                // Escribir datos en la columna A comenzando desde A1
                if (!empty($data_tipos_falla)) {
                    $newSheet->fromArray($data_tipos_falla, null, 'A1');
                }

                // Agregar tipos de luminaria en la columna C, comenzando desde C1
                $tipos_luminaria = TipoLuminaria::all();
                $data_tipos_luminaria[]= ['Tipos de luminaria'];

                // Agregar cada tipo de luminaria en una nueva fila en la columna C
                foreach ($tipos_luminaria as $tipo) {
                    $data_tipos_luminaria[] = [$tipo->nombre];
                }

                // Escribir datos en la columna C comenzando desde C1
                if (!empty($data_tipos_luminaria)) {
                    $newSheet->fromArray($data_tipos_luminaria, null, 'C1');
                }

                // Agregar compañias en la celda E1
                $companias = Compania::all();
                $data_companias[]= ['Compañias'];

                // Agregar cada compañia en una nueva fila en la columna E
                foreach ($companias as $compania) {
                    $data_companias[] = [$compania->nombre];
                }

                // Escribir datos en la columna E comenzando desde E1
                if (!empty($data_companias)) {
                    $newSheet->fromArray($data_companias, null, 'E1');
                }

                // Agregar encabezado "Condicion Lampara" en la columna I
                $newSheet->setCellValue('G1', 'Condicion Lampara');

                // Agregar "S" y "N" en la columna I comenzando desde I2
                $newSheet->setCellValue('G2', 'S');
                $newSheet->setCellValue('G3', 'N');
            },
        ];
    }
}
