<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo_personas_id_fk',
        'nombre',
        'apellidos',
        'cedula',
        'celular',
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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = Hash::make($user->password);
        });

        static::updating(function ($user) {
            $user->password = Hash::make($user->password);
        });
    }

    public function tipoPersona()
    {
        return $this->belongsTo(TipoPersona::class, 'tipo_personas_id_fk');
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_usuario', 'usuario_id_fk', 'asignatura_id_fk');
    }

    public function asignaturas_evidencias()
    {
        return $this->hasMany(AsignaturaEvidencia::class, 'usuario_id_fk');
    }

    public function permisos()
    {
        return $this->hasMany(PermisosUsuario::class, 'usuario_id_fk');
    }
}
