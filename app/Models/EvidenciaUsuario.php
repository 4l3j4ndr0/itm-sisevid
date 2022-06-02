<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaUsuario extends Model
{
    use HasFactory;

    protected $table = 'evidencia_usuarios';

    protected $fillable = [
        'evidencia_id_fk',
        'usuario_id_fk'
    ];

    public $timestamps = false;

    public function evidencia()
    {
        return $this->belongsTo(Evidencia::class, 'evidencia_id_fk');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id_fk');
    }
}
