<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    use HasFactory;

    protected $table = 'distrito';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'municipio_id',
        'extension_territorial',
        'poblacion'
    ];

    protected $guarded = [];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id');
    }

    public function distritoId($nombre)
    {
        $distrito = Distrito::where('nombre', '=', $nombre)->first();
        if ($distrito) {
            return $distrito->id;
        }
        return 0;
    }

    public function companias()
    {
        return $this->belongsToMany(Compania::class, 'distrito_has_compania', 'distrito_id', 'compania_id');
    }
}
