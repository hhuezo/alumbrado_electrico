<?php

namespace App\Models\catalogo;

use App\Models\BaseDatosSiget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLuminaria extends Model
{
    use HasFactory;

    protected $table = 'tipo_luminaria';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'activo',
        'icono'
    ];

    protected $guarded = [];

    public function baseDatosSiget()
    {
        return $this->hasMany(BaseDatosSiget::class, 'tipo_luminaria_id');
    }

     public function potenciaPromedio()
    {
        return $this->hasMany(PotenciaPromedio::class, 'tipo_luminaria_id');
    }
}
