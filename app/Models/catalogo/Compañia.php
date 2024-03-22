<?php

namespace App\Models\catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compañia extends Model
{
    use HasFactory;

    protected $table = 'compañia';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'activo',
    ];
}
