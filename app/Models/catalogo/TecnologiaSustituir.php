<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TecnologiaSustituir extends Model
{
    use HasFactory;

    protected $table = 'tecnologia_sustituir';

    //protected $primaryKey = 'tecnologia_actual_id';
    //protected $primaryKey = ['tecnologia_actual_id', 'tecnologia_sustituir_id'];


    protected $fillable = [
        'tecnologia_actual_id',
        'tecnologia_sustituir_id',
        'fecha_creacion',
        'fecha_modificacion',
    ];

    protected $guarded = [];

    public $timestamps = false;

    public function tecnologiaActual()
    {
        return $this->belongsTo(PotenciaPromedio::class, 'tecnologia_actual_id', 'id');
    }

    public function tecnologiaSustituir()
    {
        return $this->belongsTo(PotenciaPromedio::class, 'tecnologia_sustituir_id', 'id');
    }

}
