<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    use HasFactory;

    protected $table = 'compania';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function distritos()
    {
        return $this->belongsToMany(Distrito::class, 'distrito_has_compania', 'compania_id', 'distrito_id');
    }
}
