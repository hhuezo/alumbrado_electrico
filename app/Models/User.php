<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\catalogo\Departamento;
use App\Models\catalogo\Distrito;
use App\Models\catalogo\Municipio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_rol()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id');
    }

    public function distritos()
    {
        return $this->belongsToMany(Distrito::class, 'users_has_distrito');
    }

    public function get_municipios($id)
    {
        $user = User::findOrFail($id);
        $distritos_id = $user->distritos->pluck('municipio_id')->toArray();
        $distritos_id_uniques = array_unique($distritos_id);
        $municipios =  Municipio::whereIn('id',$distritos_id_uniques)->get();
        return $municipios;
    }

    public function get_departamentos($id)
    {
        $user = User::findOrFail($id);
        $municipios_id = $user->distritos->pluck('municipio_id')->toArray();
        $municipios_id_uniques = array_unique($municipios_id);
        $departamentos_array =  Municipio::whereIn('id',$municipios_id_uniques)->pluck('departamento_id')->toArray();
        $departamentos = Departamento::whereIn('id',$departamentos_array)->get();
        return $departamentos;
    }
}
