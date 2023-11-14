<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLuminaria extends Model
{
    use HasFactory;

    protected $table='tipo_luminaria';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'activo',
    ];

    protected $guarded =[

    ];
}
