<?php

namespace App\Models\control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorEnergia extends Model
{
    use HasFactory;

    protected $table = 'valor_energia';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'anio',
        'mes',
        'valor',
    ];

    protected $guarded = [];

    protected $appends = ['suma_valor_detalle']; // Agrega esto

    public function detalles()
    {
        return $this->hasMany(ValorEnergiaDetalle::class);
    }

    // Accessor para la suma de los valores de los detalles
    public function getSumaValorDetalleAttribute()
    {
        return $this->detalles->sum('valor');
    }

    //valor de compañia por tipo
    public function getValorCompania($valor_energia_id, $compania_id, $tipo)
    {
        try {
            $registro = ValorEnergiaDetalle::where('valor_energia_id', $valor_energia_id)
                ->where('compania_id', $compania_id)
                ->where('tipo', $tipo)
                ->firstOrFail();
            return $registro->valor;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Aquí capturas la excepción en caso de que no se encuentre el registro.
            return '';
        }
    }
}
