<?php

namespace App\Models\control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorEnergia extends Model
{
    use HasFactory;

    protected $table='valor_energia';

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
