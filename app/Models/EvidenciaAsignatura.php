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
}
