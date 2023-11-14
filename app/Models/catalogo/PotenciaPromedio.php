<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotenciaPromedio extends Model
{
    use HasFactory;

    protected $table = 'potencia_promedio';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'tipo_luminaria_id',
        'potencia',
        'consumo_promedio'
    ];

    protected $guarded = [];

    public function tipo_luminaria()
    {
        return $this->belongsTo(TipoLuminaria::class, 'tipo_luminaria_id', 'id');
    }
}
