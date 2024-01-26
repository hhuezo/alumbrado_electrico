<?php

namespace App\Imports;

use App\Models\BaseDatosSiget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class DataBaseImport implements ToModel, WithHeadingRow
{
    private $rowNumber = 0;
    public function model(array $row)
    {
        if ($this->rowNumber == 0) {
            $this->validateHeaders($row);
        } else {
            $errors = [];
            $validationErrors = [];

            // Validar que los datos no estén vacíos y tengan el formato adecuado
            if (empty($row['2']) || $row['2'] === null  || !is_numeric($row['2'])) {
                $errors[] = "El campo 'codigomunicipio' debe ser un número y no puede estar vacío.";
            }

            if (empty($row['3']) || $row['3'] === null ) {
                $errors[] = "El campo 'municipio' no puede estar vacío.";
            }

            if (empty($row['4']) || is_null($row['4']) || !is_numeric($row['4'])) {
                $errors[] = "El campo 'cod_tipo_luminaria' debe ser un número y no puede estar vacío.";
            }

            if (empty($row['5']) || is_null($row['5']) || !is_numeric($row['5'])) {
                $errors[] = "El campo 'potencianominal' debe ser un número y no puede estar vacío.";
            }

            // Verificar y corregir el formato del campo 'consumo_mensual'
            if (!isset($row['6']) || $row['6'] === null || !is_numeric($row['6'])) {
                $errors[] = "El campo 'consumo_mensual' debe ser un número y no puede estar vacío.";
            }

            if ((!isset($row['7']) || is_null($row['7']) || !is_numeric($row['7'])) && $row['7'] !== 0) {
                $errors[] = "El campo 'nluminarias' debe ser un número y no puede estar vacío.";
            }
            if (!empty($errors)) {
                $errors[] = "Los errores corresponden a la fila ".$this->rowNumber +1;
                $errorMessages = implode(' ', $errors);
                throw new \Exception($errorMessages);

            }

            return new BaseDatosSiget([
                'municipio_id'     => $row['2'],
                'municipio'     => $row['3'],
                'tipo_luminaria_id'     => $row['4'],
                'potencia_nominal'     => $row['5'],
                'consumo_mensual'     => $row['6'],
                'numero_luminarias'     => $row['7']
            ]);
        }

        $this->rowNumber++;




        // Tu código aquí
    }

    public function validateHeaders(array $row)
    {
        $expectedHeaders = [
            'IDUSUAR',
            'NOMBREUSUARIO',
            'CODIGOMUNICIPIO',
            'MUNICIPIO',
            'COD_TIPO_LUMINARIA',
            'POTENCIANOMINAL',
            'CONSUMOMENSUAL',
            'NLUMINARIAS',
            'FECHAULTIMOCENSO'
        ];

        $missingHeaders = array_diff($expectedHeaders, $row);
        if ($missingHeaders) {
            //dd($row,$expectedHeaders);
            throw new \Exception('Faltan los siguientes encabezados: ' . implode(', ', $missingHeaders));
        }
    }

    public function headingRow(): int
    {
        return 0; // Esto especifica que la primera fila debe usarse como fila de encabezados
    }
}
