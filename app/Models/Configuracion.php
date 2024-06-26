<?php

namespace App\Models;

use App\Models\catalogo\TipoDocumento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuracion';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'api_key_maps',
        'valor_kwh',
    ];

    protected $guarded = [];

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id', 'id');
    }
}
