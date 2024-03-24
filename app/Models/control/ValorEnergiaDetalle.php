<?php

namespace App\Models\control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorEnergiaDetalle extends Model
{
    use HasFactory;

    protected $table='valor_energia_detalle';

    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'compania_id',
        'valor_energia_id',
        'valor',
        'tipo'
    ];

    protected $guarded =[

    ];

    public function valor_energia()
    {
        return $this->belongsTo(ValorEnergia::class);
    }


}
