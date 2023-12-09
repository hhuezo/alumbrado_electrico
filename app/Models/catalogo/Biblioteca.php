<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biblioteca extends Model
{
    use HasFactory;

    protected $table = 'biblioteca';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'tipo_documento_id',
        'titulo',
        'descripcion',
        'archivo',
        'formato',
        'descargable',
        'fecha_creacion',
        'fecha_modificacion',
        'usuario_creacion',
        'usuario_modificacion'
    ];

    protected $guarded = [];

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id', 'id');
    }
}
