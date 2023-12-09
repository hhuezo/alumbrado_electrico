<?php

namespace App\Models\control;

use App\Models\catalogo\Distrito;
use App\Models\catalogo\EstadoReporteFalla;
use App\Models\catalogo\TipoFalla;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteFalla extends Model
{
    use HasFactory;

    protected $table='reporte_falla';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'fecha',
        'distrito_id',
        'tipo_falla_id',
        'descripcion',
        'latitud',
        'longitud',
        'url_foto',
        'telefono_contacto',
        'nombre_contacto',
        'estado_reporte_id',
        'usuario_creacion',
        'usuario_modificacion',
        'fecha_creacion',
        'fecha_modificacion',

    ];

    protected $guarded =[

    ];

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id', 'id');
    }

    public function tipo_falla()
    {
        return $this->belongsTo(TipoFalla::class, 'tipo_falla_id', 'id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoReporteFalla::class, 'estado_reporte_id', 'id');
    }
}
