<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $table = 'asignaturas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'programa_id_fk',
        'ciclo_id_fk',
        'asignatura',
        'creditos'
    ];
}
