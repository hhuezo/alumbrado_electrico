<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoReporteFalla extends Model
{
    use HasFactory;

    protected $table = 'estado_reporte_falla';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'activo',
        'fecha_creacion',
        'fecha_modificacion',
        'usuario_creacion',
        'usuario_modificacion'
    ];

    protected $guarded = [];
}
