<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table='departamento';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
    ];

    protected $guarded =[

    ];

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'departamento_id');
    }

}
