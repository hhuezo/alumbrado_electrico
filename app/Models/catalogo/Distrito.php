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
        'departamento_id'
    ];

    protected $guarded = [];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function distritoId($nombre)
    {
        $distrito = Distrito::where('nombre','=',$nombre)->first();
        if($distrito)
        {
            return $distrito->id;
        }
        return 0;
    }
}
