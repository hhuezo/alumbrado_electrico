<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionSmtp extends Model
{
    use HasFactory;
    protected $table = 'configuracion_smtp';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'from_address',
    ];
}
