<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipio';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'departamento_id',
        'convenio',
        'nombre_responsable',
        'correo_responsable',
        'telefono_responsable',
        'direccion_responsable'
    ];

    protected $guarded = [];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'municipio_id');
    }


}
