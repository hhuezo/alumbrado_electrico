<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseDatosSiget extends Model
{
    use HasFactory;
    protected $table = 'base_datos_siget';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'municipio_id',
        'municipio',
        'tipo_luminaria_id',
        'potencia_nominal',
        'consumo_mensual',
        'numero_luminarias',
        'anio',
        'mes',
    ];

    protected $guarded = [];

}
