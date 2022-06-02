<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaAsignatura extends Model
{
    use HasFactory;

    protected $table = 'evidencia_asignaturas';

    protected $fillable = [
        'evidencia_id_fk',
        'asignatura_id_fk'
    ];

    public $timestamps = false;

    public function evidencia()
    {
        return $this->belongsTo(Evidencia::class, 'evidencia_id_fk');
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id_fk');
    }
}
