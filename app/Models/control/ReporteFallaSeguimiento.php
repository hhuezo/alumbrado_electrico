<?php

namespace App\Models\control;

use App\Models\catalogo\EstadoReporteFalla;
use App\Models\catalogo\TipoFalla;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteFallaSeguimiento extends Model
{
    use HasFactory;

    protected $table='reporte_falla_seguimiento';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'reporte_falla_id',
        'censo_luminaria_id',
        'fecha',
        'condicion_lampara',
        'tipo_falla_id',
        'observacion',
        'estado_reporte_falla_id'

    ];

    protected $guarded =[

    ];

    public function reporte_falla()
    {
        return $this->belongsTo(ReporteFalla::class);
    }

    public function censo_luminaria()
    {
        return $this->belongsTo(CensoLuminaria::class);
    }

    public function tipo_falla()
    {
        return $this->belongsTo(TipoFalla::class);
    }

    public function estado_reporte()
    {
        return $this->belongsTo(EstadoReporteFalla::class, 'estado_reporte_falla_id', 'id');
    }
}
