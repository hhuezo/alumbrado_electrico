<?php

namespace App\Models\control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorMensualEnergia extends Model
{
    use HasFactory;

    protected $table='valor_mensual_energia';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'anio',
        'mes',
        'valor',
    ];

    protected $guarded =[

    ];
}
