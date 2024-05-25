<?php

namespace App\Models;

use App\Models\catalogo\TipoLuminaria;
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
        'mes',
        'anio',
        'compania_id',
        'fecha_ultimo_censo',
        'total_pagar',
        'cargo_comercializacion',
        'cargo_distribucion',
        'cargo_energia',
        'cargo_tasa_municipal',
        'compania',
        'distrito_id',
        'distrito',
        'area',
        'tecnologia',
    ];


    protected $guarded = [];

    public function tipoLuminaria()
    {
        return $this->belongsTo(TipoLuminaria::class, 'tipo_luminaria_id', 'id');
    }

}
