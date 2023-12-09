<?php

namespace App\Models\control;

use App\Models\catalogo\Distrito;
use App\Models\catalogo\TipoLuminaria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CensoLuminaria extends Model
{
    use HasFactory;

    protected $table='censo_luminaria';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'tipo_luminaria_id',
        'fecha_ingreso',
        'potencia_nominal',
        'consumo_mensual',
        'fecha_ultimo_censo',
        'distrito_id',
        'usuario_ingreso',
        'codigo_luminaria',
        'decidad_luminicia',
    ];

    protected $guarded =[

    ];

    public function tipo_luminaria()
    {
        return $this->belongsTo(TipoLuminaria::class, 'tipo_luminaria_id', 'id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id', 'id');
    }
}
