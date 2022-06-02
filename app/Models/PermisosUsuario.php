<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisosUsuario extends Model
{
    use HasFactory;

    protected $table = 'permisos_usuarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'usuario_id_fk',
        'titulo',
        'path'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id_fk');
    }
}
